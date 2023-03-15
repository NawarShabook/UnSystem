<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;    // Must Must use
use Illuminate\Support\Facades\Blade;   // Must Must use

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // custome direction
        Blade::if('isAdmin', function () {
            return auth()->check() && auth()->user()->role == 1;
        });

        Blade::if('isStudent', function () {
            return auth()->check() && auth()->user()->role == 0;
        });
    }
}
