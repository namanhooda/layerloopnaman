<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CustomAuthenticatedSessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $this->ensureIsNotRateLimited($request);

        $login = $request->input('login');
        $password = $request->input('password');

        // Use 'mobile' (not 'phone') if your DB column is mobile
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        $user = User::where($field, $login)->first();
        if (! $user || ! Hash::check($password, $user->password)) {
            RateLimiter::hit($this->throttleKey($request));
            throw ValidationException::withMessages([
                'login' => __('auth.failed'),
            ]);
        }

        // Clear limiter
        RateLimiter::clear($this->throttleKey($request));

        // Login user
        Auth::guard('web')->login($user, $request->boolean('remember'));

        // Regenerate session
        $request->session()->regenerate();

        // Redirect
        return redirect()->intended(config('fortify.home', '/dashboard'));
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    protected function ensureIsNotRateLimited(Request $request)
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
            return;
        }

        $seconds = RateLimiter::availableIn($this->throttleKey($request));

        throw ValidationException::withMessages([
            'login' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    protected function throttleKey(Request $request)
    {
        return Str::lower($request->input('login')) . '|' . $request->ip();
    }
}
