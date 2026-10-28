<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Services\EconfirmPaymentFinalizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Throwable;

class EconfirmWebhookController extends Controller
{
    public function checkoutFunded(Request $request, EconfirmPaymentFinalizer $finalizer)
    {
        $rawBody = $request->getContent();
        try {
            $event = json_decode($rawBody, true, 512, JSON_THROW_ON_ERROR);
        } catch (Throwable) {
            abort(400, 'Invalid webhook payload.');
        }

        abort_unless(is_array($event) && is_array($event['data'] ?? null), 400, 'Invalid webhook payload.');
        $eventId = (string) ($event['id'] ?? '');
        $eventType = (string) ($event['type'] ?? '');
        $data = $event['data'];
        $merchantReference = (string) ($data['merchant_reference'] ?? '');
        $transactionId = (string) ($data['transaction_id'] ?? '');

        abort_unless($eventId !== '' && $eventType === 'checkout.funded', 400, 'Unexpected webhook event.');
        abort_unless($request->header('X-eConfirm-Event') === 'checkout.funded', 400, 'Unexpected webhook event header.');
        abort_unless(hash_equals($eventId, (string) $request->header('X-eConfirm-Event-Id')), 400, 'Webhook event ID mismatch.');

        $payment = Payment::with('order')
            ->where('provider', 'econfirm')
            ->whereHas('order', fn ($query) => $query->where('order_number', $merchantReference))
            ->first();

        abort_unless($payment && $payment->order, 404, 'Payment not found.');
        $timestampValue = $request->header('X-eConfirm-Timestamp');
        abort_unless(is_numeric($timestampValue), 401, 'Webhook timestamp is invalid.');
        $timestamp = (int) $timestampValue;
        abort_unless($timestamp > 0 && abs(now()->timestamp - $timestamp) <= 300, 401, 'Webhook timestamp has expired.');

        $encryptedSecrets = array_filter(array_merge(
            [(string) data_get($payment->metadata, 'econfirm_webhook_secret_encrypted', '')],
            (array) data_get($payment->metadata, 'econfirm_previous_webhook_secrets_encrypted', [])
        ));
        abort_unless($encryptedSecrets !== [], 401, 'Webhook secret is unavailable.');

        $providedSignature = (string) $request->header('X-eConfirm-Signature');
        $signatureValid = false;
        foreach ($encryptedSecrets as $encryptedSecret) {
            try {
                $webhookSecret = Crypt::decryptString((string) $encryptedSecret);
                $expectedSignature = 'sha256=' . hash_hmac('sha256', $timestamp . '.' . $rawBody, $webhookSecret);
                if (hash_equals($expectedSignature, $providedSignature)) {
                    $signatureValid = true;
                    break;
                }
            } catch (Throwable) {
                continue;
            }
        }
        abort_unless($signatureValid, 401, 'Webhook signature is invalid.');

        $amount = $data['amount_kes'] ?? null;
        $currency = strtoupper((string) ($data['currency'] ?? ''));
        $status = strtolower((string) ($data['status'] ?? ''));
        abort_unless($merchantReference === $payment->order->order_number, 409, 'Merchant reference mismatch.');
        abort_unless($transactionId !== '' && hash_equals((string) $payment->provider_request_id, $transactionId), 409, 'Transaction ID mismatch.');
        abort_unless(is_numeric($amount) && abs((float) $amount - (float) $payment->amount) < 0.01, 409, 'Payment amount mismatch.');
        abort_unless($currency === strtoupper((string) $payment->currency), 409, 'Payment currency mismatch.');
        abort_unless(in_array($status, ['funded', 'escrow funded'], true), 400, 'Payment is not funded.');

        DB::transaction(function () use ($eventId, $payment, $transactionId, $finalizer) {
            $inserted = DB::table('econfirm_webhook_events')->insertOrIgnore([
                'event_id' => $eventId,
                'payment_id' => $payment->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if ($inserted) {
                $finalizer->markFunded($payment, $transactionId);
            }
        });

        return response()->noContent();
    }
}
