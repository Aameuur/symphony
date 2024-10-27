<?php

namespace App\Service;

use Twilio\Rest\Client;

class NotificationService
{
    private Client $client;
    private string $from="+15094123723";

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    // Method to send an SMS
    public function sendSms(string $phoneNumber, string $message): void
    {
        try {
            // Ensure that $client is initialized before usage
            $this->client->messages->create(
                $phoneNumber,
                [
                    'from' => $this->from,
                    'body' => $message,
                ]
            );
            echo "SMS sent to $phoneNumber: $message\n"; // For debugging purposes
        } catch (\Exception $e) {
            echo "Failed to send SMS: " . $e->getMessage() . "\n";
            // Log the detailed error message
            error_log($e->getTraceAsString());
        }
    }
}
