<?php

namespace App\Services;

use App\Exceptions\EconfirmTransactionNotFoundException;
use App\Models\Order;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class EconfirmService
{
    public function isConfigured(): bool
    {
        return filled(config('services.econfirm.api_key'))
            && filled(config('services.econfirm.seller_email'))
            && filled(config('services.econfirm.receiver_phone'));
    }

    public function createCheckout(Order $order): array
    {
        if (!$this->isConfigured()) {
            throw new RuntimeException('eConfirm hosted checkout is not configured.');
        }

        $baseUrl = rtrim(config('services.econfirm.base_url'), '/');
        $headers = [
            'Authorization' => 'Bearer ' . config('services.econfirm.api_key'),
            'Accept' => 'application/json',
        ];

        $transaction = Http::withHeaders($headers)
            ->timeout(25)
            ->post($baseUrl . '/transactions', [
                'amount' => (float) $order->total,
                'currency' => 'KES',
                'buyer_email' => $order->customer_email,
                'seller_email' => config('services.econfirm.seller_email'),
                'receiver_phone' => $this->normalizeReceiverPhone(config('services.econfirm.receiver_phone')),
                'description' => 'Mars Collection order ' . $order->order_number,
                'terms' => 'Payment for goods in order ' . $order->order_number . ', delivered to ' . data_get($order->shipping_address, 'city', 'Kenya'),
            ]);

        if (!$transaction->successful() || !($transactionId = $transaction->json('data.id'))) {
            throw new RuntimeException($this->responseFailure($transaction, 'create escrow'));
        }

        return [
            'transaction_id' => (string) $transactionId,
            'confirmation_code' => $transaction->json('data.confirmation_code'),
        ];
    }

    public function createCheckoutSession(string $transactionId, string $returnUrl, string $merchantReference, string $webhookUrl): array
    {
        $baseUrl = rtrim(config('services.econfirm.base_url'), '/');
        $response = Http::withToken(config('services.econfirm.api_key'))
            ->acceptJson()
            ->withHeaders(['Idempotency-Key' => 'order:' . $merchantReference . ':transaction:' . $transactionId . ':checkout-v2'])
            ->timeout(25)
            ->post($baseUrl . '/checkout/sessions', [
                'transaction_id' => $transactionId,
                'return_url' => $returnUrl,
                'merchant_reference' => $merchantReference,
                'webhook_url' => $webhookUrl,
            ]);

        if (!$response->successful()) {
            $failure = $this->responseFailure($response, 'create checkout session');
            if ($response->status() === 404 && str_contains(strtolower($failure), 'transaction not found for this business')) {
                throw new EconfirmTransactionNotFoundException($failure);
            }

            throw new RuntimeException($failure);
        }

        $checkoutUrl = $response->json('data.checkout_url');
        $secret = $response->json('data.checkout_secret');
        $webhookSecret = $response->json('data.webhook_secret');
        if (!$checkoutUrl || !$secret || !$webhookSecret) {
            throw new RuntimeException('eConfirm returned an incomplete checkout session response.');
        }
        if (!$this->isTrustedCheckoutUrl($checkoutUrl)) {
            throw new RuntimeException('eConfirm returned a checkout URL outside the trusted eConfirm domain.');
        }

        return [
            'checkout_url' => $checkoutUrl,
            'checkout_secret' => $secret,
            'webhook_secret' => $webhookSecret,
            'expires_at' => $response->json('data.expires_at'),
        ];
    }

    public function getTransaction(string $transactionId): array
    {
        $baseUrl = rtrim(config('services.econfirm.base_url'), '/');
        $response = Http::withToken(config('services.econfirm.api_key'))
            ->acceptJson()
            ->timeout(20)
            ->get($baseUrl . '/transactions/' . rawurlencode($transactionId));

        if (!$response->successful() || !is_array($response->json('data'))) {
            throw new RuntimeException($this->responseFailure($response, 'get transaction status'));
        }

        return $response->json('data');
    }

    private function isTrustedCheckoutUrl(string $url): bool
    {
        $parts = parse_url($url);
        $host = strtolower($parts['host'] ?? '');

        return ($parts['scheme'] ?? '') === 'https'
            && ($host === 'econfirm.co.ke' || str_ends_with($host, '.econfirm.co.ke'));
    }

    private function normalizeReceiverPhone(?string $phone): string
    {
        $phone = preg_replace('/\D+/', '', (string) $phone);

        if (str_starts_with($phone, '0')) {
            $phone = '254' . substr($phone, 1);
        } elseif (preg_match('/^[17]\d{8}$/', $phone)) {
            $phone = '254' . $phone;
        }

        if (!preg_match('/^254[17]\d{8}$/', $phone)) {
            throw new RuntimeException('ECONFIRM_RECEIVER_PHONE must be a valid Kenyan mobile number.');
        }

        return $phone;
    }

    private function responseFailure($response, string $operation): string
    {
        $message = $response->json('message');
        $errors = $response->json('errors');
        $details = is_string($message) ? $message : '';

        if (!$details && is_array($errors)) {
            $details = collect($errors)
                ->map(fn ($value, $key) => $key . ': ' . (is_array($value) ? implode(', ', $value) : (string) $value))
                ->implode('; ');
        }

        return 'eConfirm could not ' . $operation . ' (HTTP ' . $response->status() . ')'
            . ($details ? ': ' . substr($details, 0, 300) : '.');
    }
}
