<?php

namespace App\Providers;

use Laravel\Fortify\Fortify;
use Illuminate\Support\ServiceProvider;

class FortifyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Disable Fortify default login routes
        Fortify::ignoreRoutes();

        // Specify your custom login view
        Fortify::loginView(fn () => view('auth.login'));
    }
}
