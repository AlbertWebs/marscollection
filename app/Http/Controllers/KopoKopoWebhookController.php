<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Payment;
use App\Services\KopoKopoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class KopoKopoWebhookController extends Controller
{
    public function incomingPayment(Request $request, KopoKopoService $kopokopo)
    {
        if (!$kopokopo->verifyWebhook($request->getContent(), $request->header('X-KopoKopo-Signature'))) {
            return response()->json(['message' => 'Invalid signature.'], 401);
        }

        $payload = $request->json()->all();
        $result = data_get($payload, 'data', $payload);
        $attributes = data_get($result, 'attributes', $result);
        $metadata = data_get($attributes, 'metadata', data_get($result, 'metadata', []));
        $reference = $metadata['reference'] ?? null;
        if (!$reference) {
            Log::warning('KopoKopo callback did not include our payment reference.');
            return response()->json(['received' => true]);
        }

        $payment = Payment::where('reference', $reference)->first();
        if (!$payment) {
            Log::warning('KopoKopo callback reference was not found.', ['reference' => $reference]);
            return response()->json(['received' => true]);
        }

        $providerStatus = strtolower((string) data_get($attributes, 'status', ''));
        $resource = data_get($attributes, 'event.resource', data_get($result, 'event.resource'));
        $resourceStatus = strtolower((string) data_get($resource, 'status', ''));

        if (in_array($payment->status, ['succeeded', 'refunded'], true)) {
            return response()->json(['received' => true]);
        }

        if ($providerStatus === 'success' && $resource && $resourceStatus === 'received') {
            $receivedAmount = (float) data_get($resource, 'amount', 0);
            $receivedCurrency = strtoupper((string) data_get($resource, 'currency', ''));
            if (abs($receivedAmount - (float) $payment->amount) > 0.01 || $receivedCurrency !== $payment->currency) {
                Log::warning('KopoKopo callback amount or currency mismatch.', ['payment_id' => $payment->id]);
                return response()->json(['message' => 'Payment details do not match.'], 422);
            }

            DB::transaction(function () use ($payment, $resource) {
                $locked = Payment::whereKey($payment->id)->lockForUpdate()->first();
                if (in_array($locked->status, ['succeeded', 'refunded'], true)) return;

                $locked->update([
                    'status' => 'succeeded',
                    'provider_reference' => data_get($resource, 'reference'),
                    'failure_reason' => null,
                ]);

                if ($locked->order && $locked->order->status === 'pending') {
                    $locked->order->update(['status' => 'processing']);
                }
                if ($locked->cart_session_id) {
                    Cart::where('session_id', $locked->cart_session_id)->delete();
                }
            });
        } elseif (in_array($providerStatus, ['failed', 'failure'], true)) {
            $payment->update([
                'status' => 'failed',
                'failure_reason' => 'KopoKopo reported that the payment did not complete.',
            ]);
        } elseif ($providerStatus === 'pending') {
            $payment->update(['status' => 'initiated']);
        }

        return response()->json(['received' => true]);
    }
}
