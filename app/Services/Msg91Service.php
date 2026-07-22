<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class Msg91Service
{
    public function sendOtp($phone)
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post(
            'https://control.msg91.com/api/v5/otp',
            []
        );

        $response = Http::post(
            'https://control.msg91.com/api/v5/otp?template_id=' .
            config('services.msg91.template_id') .
            '&mobile=91' . $phone .
            '&authkey=' . config('services.msg91.auth_key'),
            []
        );

        return $response->json();
    }

    public function verifyOtp($phone, $otp)
    {
        $response = Http::withHeaders([
            'authkey' => config('services.msg91.auth_key'),
        ])->get('https://control.msg91.com/api/v5/otp/verify', [
            'mobile' => '91'.$phone,
            'otp' => $otp,
        ]);

        return $response->json();
    }
}