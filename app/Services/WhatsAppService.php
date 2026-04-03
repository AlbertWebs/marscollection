<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Setting;

class WhatsAppService
{
    /**
     * Send a WhatsApp message via the Node.js microservice
     */
    public static function sendMessage($number, $message)
    {
        // WhatsApp service runs on port 3001 on the same server
        $url = 'http://127.0.0.1:3001/send';

        try {
            $response = Http::timeout(5)->post($url, [
                'number' => self::formatNumber($number),
                'message' => $message,
            ]);

            if (!$response->successful()) {
                Log::error('WhatsApp service failed: ' . $response->body());
                return false;
            }

            return true;
        } catch (\Exception $e) {
            Log::error('WhatsApp service exception: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Format number for WhatsApp (remove +, spaces, etc.)
     */
    private static function formatNumber($number)
    {
        return preg_replace('/\D/', '', $number);
    }
}
