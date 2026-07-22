<?php

namespace App\Services;

use Twilio\Rest\Client;

class TwilioService
{
    protected Client $client;

    public function __construct()
    {
        $this->client = new Client(
            config('services.twilio.sid'),
            config('services.twilio.token')
        );
    }

    public function sendOtp($phone)
    {
        return $this->client->verify->v2
            ->services(config('services.twilio.verify_sid'))
            ->verifications
            ->create($phone, "sms");
    }

    public function verifyOtp($phone, $otp)
    {
        return $this->client->verify->v2
            ->services(config('services.twilio.verify_sid'))
            ->verificationChecks
            ->create([
                "to" => $phone,
                "code" => $otp
            ]);
    }
}