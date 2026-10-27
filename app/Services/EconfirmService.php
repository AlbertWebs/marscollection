<?php

namespace App\Services;

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
                'receiver_phone' => config('services.econfirm.receiver_phone'),
                'description' => 'Mars Collection order ' . $order->order_number,
                'terms' => 'Payment for goods in order ' . $order->order_number . ', delivered to ' . data_get($order->shipping_address, 'city', 'Kenya'),
            ]);

        if (!$transaction->successful() || !($transactionId = $transaction->json('data.id'))) {
            throw new RuntimeException('eConfirm could not create the escrow transaction.');
        }

        return [
            'transaction_id' => (string) $transactionId,
            'confirmation_code' => $transaction->json('data.confirmation_code'),
        ];
    }

    public function createCheckoutSession(string $transactionId, string $returnUrl, string $merchantReference): array
    {
        $baseUrl = rtrim(config('services.econfirm.base_url'), '/');
        $response = Http::withToken(config('services.econfirm.api_key'))
            ->acceptJson()
            ->withHeaders(['Idempotency-Key' => 'order:' . $merchantReference . ':checkout-v1'])
            ->timeout(25)
            ->post($baseUrl . '/checkout/sessions', [
                'transaction_id' => $transactionId,
                'return_url' => $returnUrl,
                'merchant_reference' => $merchantReference,
            ]);

        $checkoutUrl = $response->json('data.checkout_url');
        $secret = $response->json('data.checkout_secret');
        if (!$response->successful() || !$checkoutUrl || !$secret || !$this->isTrustedCheckoutUrl($checkoutUrl)) {
            throw new RuntimeException('eConfirm did not return a valid hosted checkout session.');
        }

        return [
            'checkout_url' => $checkoutUrl,
            'checkout_secret' => $secret,
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
            throw new RuntimeException('eConfirm transaction status could not be verified.');
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
}
