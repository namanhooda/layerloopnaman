<?php

namespace App\Actions\Fortify;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\LoginViewResponse;
use Laravel\Fortify\Fortify;

class AttemptToAuthenticateWithEmailOrMobile
{
    public function __invoke(Request $request)
    {
        $login = $request->input('login');
        $password = $request->input('password');

        // Check if input is email or mobile
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile';

        if (Auth::attempt([$fieldType => $login, 'password' => $password], $request->boolean('remember'))) {
            $request->session()->regenerate();
            return app(LoginResponse::class);
        }

        return back()->withErrors([
            'login' => 'The provided credentials are incorrect.',
        ]);
    }
}
