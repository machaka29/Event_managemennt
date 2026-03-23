<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NextSmsService
{
    protected $baseUrl = 'https://messaging-service.co.tz/api/sms/v1/text/single';

    public function sendSms($to, $message, $sender = null)
    {
        $username = env('NEXTSMS_USERNAME', 'demo');
        $password = env('NEXTSMS_PASSWORD', 'demo');
        $sender = $sender ?: env('NEXTSMS_SENDER_ID', 'NEXTSMS');

        if (!$username || !$password) {
            Log::error('NextSMS credentials missing');
            return false;
        }

        $to = $this->formatPhoneNumber($to);
        if (!$to) return false;

        try {
            $response = Http::withBasicAuth($username, $password)
                ->withHeaders([
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ])
                ->post($this->baseUrl, [
                    'from' => $sender,
                    'to' => $to,
                    'text' => $message,
                    'reference' => 'ev_' . uniqid()
                ]);

            if ($response->successful()) {
                Log::info("NextSMS sent successfully to {$to}");
                return true;
            } else {
                Log::error("NextSMS failed for {$to}: " . $response->body());
                return false;
            }
        } catch (\Exception $e) {
            Log::error("NextSMS exception for {$to}: " . $e->getMessage());
            return false;
        }
    }

    protected function formatPhoneNumber($phone)
    {
        // Keep only digits
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // Remove leading 0 if starting with 0
        if (str_starts_with($phone, '0')) {
            $phone = '255' . substr($phone, 1);
        }
        
        // Ensure starting with + for standard NextSMS format if required, but NextSMS accepts 255...
        // Return only if valid length (usually 12 digits for TZ)
        if (strlen($phone) < 9) return null;

        return $phone;
    }
}
