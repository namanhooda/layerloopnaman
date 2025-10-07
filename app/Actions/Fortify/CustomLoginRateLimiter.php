<?php

namespace App\Actions\Fortify;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CustomLoginRateLimiter
{
    public function ensureIsNotRateLimited(Request $request)
    {
        $key = $this->throttleKey($request);

        if (! RateLimiter::tooManyAttempts($key, 5)) {
            return;
        }

        $seconds = RateLimiter::availableIn($key);

        throw ValidationException::withMessages([
            'login' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    public function hit(Request $request)
    {
        RateLimiter::hit($this->throttleKey($request));
    }

    public function clear(Request $request)
    {
        RateLimiter::clear($this->throttleKey($request));
    }

    protected function throttleKey(Request $request)
    {
        return Str::lower($request->input('login')).'|'.$request->ip();
    }
}
