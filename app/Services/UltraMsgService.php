<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UltraMsgService
{
    protected string $instanceId;
    protected string $token;
    protected string $apiUrl;

    public function __construct()
    {
        $this->instanceId = env('ULTRAMSG_INSTANCE_ID', '');
        $this->token = env('ULTRAMSG_TOKEN', '');
        $this->apiUrl = "https://api.ultramsg.com/{$this->instanceId}/messages/chat";
    }

    /**
     * Send a WhatsApp message using UltraMsg API.
     *
     * @param string $phoneNumber The recipient phone number (with country code, e.g. +521234567890)
     * @param string $message The text message to send
     * @return bool True if successful, false otherwise
     */
    public function sendMessage(string $phoneNumber, string $message): bool
    {
        if (empty($this->instanceId) || empty($this->token)) {
            Log::warning('UltraMsg credentials are not set.');
            return false;
        }

        try {
            $response = Http::withoutVerifying()->asForm()->post($this->apiUrl, [
                'token' => $this->token,
                'to' => $phoneNumber,
                'body' => $message
            ]);

            if ($response->successful()) {
                return true;
            } else {
                Log::error('Error sending UltraMsg WhatsApp: ' . $response->body());
                return false;
            }
        } catch (\Exception $e) {
            Log::error('Exception in UltraMsg WhatsApp: ' . $e->getMessage());
            return false;
        }
    }
}
