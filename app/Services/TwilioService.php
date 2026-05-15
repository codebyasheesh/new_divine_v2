<?php

namespace App\Services;

use Twilio\Rest\Client;

class TwilioService
{
    protected $client;
    protected $from;

    public function __construct()
    {
        $this->client = new Client(
            config('twilio.sid'),
            config('twilio.token')
        );

        $this->from = config('twilio.from');
    }

    public function sendSms(string $to, string $message)
    {
        return $this->client->messages->create(
            $to,
            [
                'from' => $this->from,
                'body' => $message,
            ]
        );
    }
}
