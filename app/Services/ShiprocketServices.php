<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class ShiprocketServices
{
    private $base;
    private $token;

    public function __construct()
    {
        $this->base = config('services.shiprocket.base');
        $this->token = $this->getToken();
    }

    private function getToken()
    {
        return cache()->remember('shiprocket_token', 50 * 60, function () {

            $res = Http::post($this->base.'/auth/login', [
                'api_key' => config('services.shiprocket.key'),
                'secret_key' => config('services.shiprocket.secret')
            ]);

            return $res['token'];
        });
    }

    private function client()
    {
        return Http::withToken($this->token);
    }

    public function createOrder($payload)
    {
        return $this->client()
            ->post($this->base.'/orders/create/adhoc', $payload)
            ->json();
    }
}
