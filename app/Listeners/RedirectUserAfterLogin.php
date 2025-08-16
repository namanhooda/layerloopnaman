<?php
namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Session;

class RedirectUserAfterLogin
{
    public function handle(Login $event): void
    {
        $user = $event->user;

        // You can't redirect from here directly, so we'll store the intended redirect
        if ($user->hasRole('admin')) {
            Session::put('url.intended', route('admin.dashboard'));
        } else {
            Session::put('url.intended', url()->previous()); // or route('home')
        }
    }
}
