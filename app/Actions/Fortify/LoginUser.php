<?php

namespace App\Actions\Fortify;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginUser
{
    public function __invoke(Request $request)
    {
        // Throttle protection
        $limiter = app(CustomLoginRateLimiter::class);
        $limiter->ensureIsNotRateLimited($request);

        // Validate credentials
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $login = $request->input('login');
        $password = $request->input('password');

        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
        $user = User::where($field, $login)->first();

        if (! $user || ! Hash::check($password, $user->password)) {
            $limiter->hit($request); // count failed attempt
            return null;
        }

        $limiter->clear($request); // reset on success
        return $user;
    }
}
