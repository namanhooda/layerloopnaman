<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Exception;

class NimbusPostAuthService
{
    const CACHE_KEY = 'nimbuspost_auth_token';
    const CACHE_TTL = 60 * 60 * 23; // 23 hours

    public static function getToken(): string
    {
        if (Cache::has(self::CACHE_KEY)) {
            return Cache::get(self::CACHE_KEY);
        }

        return self::loginAndStoreToken();
    }

private static function loginAndStoreToken(): string
{
    $response = Http::withHeaders([
    'Accept'       => 'application/json',
    'Content-Type' => 'application/json',
    'User-Agent'   => 'Laravel-App/1.0',
])->post('https://api.nimbuspost.com/v1/users/login', [
    'email'    => env('NIMBUS_EMAIL'),
    'password' => env('NIMBUS_PASSWORD'),
]);
    $data = $response->json();

    if (!$response->successful()) {
        logger()->error('NimbusPost Login Failed', [
            'status' => $response->status(),
            'response' => $data,
        ]);

        throw new \Exception(
            $data['message'] ?? 'NimbusPost login failed with status '.$response->status()
        );
    }

    if (empty($data['data'])) {
        throw new \Exception('NimbusPost token missing in response');
    }

    Cache::put(self::CACHE_KEY, $data['data'], now()->addHours(23));
    
    return $data['data'];
}




    public static function clearToken(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
