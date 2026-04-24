<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    /**
     * Send an SMS message using the configured gateway.
     */
    public function send(string $phone, string $message, $campus_id = null): bool
    {
        $provider = Setting::get('sms_provider', 'twilio', $campus_id);
        $apiKey = Setting::get('sms_api_key', null, $campus_id);
        $apiSecret = Setting::get('sms_api_secret', null, $campus_id);

        if (!$apiKey || !$apiSecret) {
            Log::error("SMS sending failed: Missing API credentials for {$provider}");
            return false;
        }

        try {
            if ($provider === 'twilio') {
                return $this->sendViaTwilio($phone, $message, $apiKey, $apiSecret);
            } elseif ($provider === 'nexmo') {
                return $this->sendViaNexmo($phone, $message, $apiKey, $apiSecret);
            }
        } catch (\Exception $e) {
            Log::error("SMS Gateway Error ({$provider}): " . $e->getMessage());
        }

        return false;
    }

    protected function sendViaTwilio($phone, $message, $sid, $token): bool
    {
        // Twilio API URL for sending SMS
        $url = "https://api.twilio.com/2010-04-01/Accounts/{$sid}/Messages.json";
        
        $response = Http::withBasicAuth($sid, $token)->asForm()->post($url, [
            'To' => $phone,
            'From' => Setting::get('sms_from_number', 'EduCore'),
            'Body' => $message,
        ]);

        return $response->successful();
    }

    protected function sendViaNexmo($phone, $message, $key, $secret): bool
    {
        $response = Http::post('https://rest.nexmo.com/sms/json', [
            'api_key' => $key,
            'api_secret' => $secret,
            'to' => $phone,
            'from' => Setting::get('sms_from_number', 'EduCore'),
            'text' => $message,
        ]);

        return $response->successful();
    }

    /**
     * Legacy method support if needed by existing code
     */
    public function queueAbsenceAlert(array $payload): void
    {
        $message = "Attendance Alert: {$payload['student_name']} is absent today.";
        $this->send($payload['phone'], $message);
    }
}
