<?php

namespace App\Helpers;

class ShiprocketHelper
{
    public static function hmac($payload)
    {
        $secret = config('services.shiprocket.secret');

        return base64_encode(
            hash_hmac('sha256', $payload, $secret, true)
        );
    }
}
