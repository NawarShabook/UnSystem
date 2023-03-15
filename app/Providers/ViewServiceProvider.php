<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;

use Illuminate\Support\ServiceProvider;

use App\Models\StudentReq;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        
        View::composer('layouts.app', function ($view) {
            $ReqNum=count(StudentReq::all());
            $view->with('ReqNum', $ReqNum); // Replace 5 with your actual notification count logic
        });
    }
}
