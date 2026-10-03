<?php

namespace App\Services;

use App\Models\Payment;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class KopoKopoService
{
    public function isConfigured(): bool
    {
        return filled(config('services.kopokopo.client_id'))
            && filled(config('services.kopokopo.client_secret'))
            && filled(config('services.kopokopo.api_key'))
            && filled(config('services.kopokopo.till_number'));
    }

    public function initiateIncomingPayment(Payment $payment, string $firstName, string $lastName, ?string $email, string $phone, ?string $notes = null): array
    {
        if (!$this->isConfigured()) {
            throw new RuntimeException('KopoKopo is not configured.');
        }

        $token = $this->accessToken();
        $callbackUrl = config('services.kopokopo.callback_url') ?: route('payments.kopokopo.callback');
        $baseUrl = rtrim(config('services.kopokopo.base_url'), '/');

        $response = Http::acceptJson()
            ->withToken($token)
            ->withUserAgent('MarsCollection/1.0')
            ->timeout(25)
            ->post($baseUrl . '/api/v2/incoming_payments', [
                'payment_channel' => 'M-PESA STK Push',
                'till_number' => config('services.kopokopo.till_number'),
                'subscriber' => array_filter([
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'phone_number' => $phone,
                    'email' => $email,
                ], fn ($value) => $value !== null && $value !== ''),
                'amount' => [
                    'currency' => $payment->currency,
                    'value' => (float) $payment->amount,
                ],
                'metadata' => [
                    'customer_id' => (string) ($payment->user_id ?? 'guest'),
                    'reference' => $payment->reference,
                    'notes' => $notes ?: 'Mars Collection payment',
                ],
                '_links' => ['callback_url' => $callbackUrl],
            ]);

        if (!$response->successful()) {
            throw new RuntimeException('KopoKopo rejected the STK request.');
        }

        $requestUrl = $response->header('Location')
            ?: data_get($response->json(), 'data.attributes._links.self')
            ?: data_get($response->json(), 'data._links.self');
        $requestId = data_get($response->json(), 'data.id');

        if (!$requestId && $requestUrl) {
            $requestId = basename(parse_url($requestUrl, PHP_URL_PATH) ?: '');
        }

        if (!$requestUrl && !$requestId) {
            throw new RuntimeException('KopoKopo did not return a payment request reference.');
        }

        return ['request_id' => $requestId, 'request_url' => $requestUrl];
    }

    public function verifyWebhook(string $rawBody, ?string $signature): bool
    {
        $apiKey = config('services.kopokopo.api_key');
        if (!$apiKey || !$signature) {
            return false;
        }

        return hash_equals(hash_hmac('sha256', $rawBody, $apiKey), $signature);
    }

    private function accessToken(): string
    {
        $clientId = config('services.kopokopo.client_id');
        $clientSecret = config('services.kopokopo.client_secret');
        $baseUrl = rtrim(config('services.kopokopo.base_url'), '/');
        $cacheKey = 'kopokopo.access_token.' . sha1($clientId);

        return Cache::remember($cacheKey, now()->addMinutes(55), function () use ($clientId, $clientSecret, $baseUrl) {
            $response = Http::asForm()
                ->acceptJson()
                ->withUserAgent('MarsCollection/1.0')
                ->timeout(20)
                ->post($baseUrl . '/oauth/token', [
                    'client_id' => $clientId,
                    'client_secret' => $clientSecret,
                    'grant_type' => 'client_credentials',
                ]);

            if (!$response->successful() || !($token = $response->json('access_token'))) {
                throw new RuntimeException('Unable to authenticate with KopoKopo.');
            }

            return $token;
        });
    }
}
