<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;    // Must Must use
use Illuminate\Support\Facades\Blade;   // Must Must use
use App\Models\StudentReq;
use App\Models\Student;


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

        //this for if the student is sended request or is actually added to the database 
        Blade::if('haveReq', function () {
            $studentReq=StudentReq::where('user_id',Auth::user()->id)->first();

            if($studentReq)
            {
                return true;
            }
            else
            {
                return false;
            }
        });

        //this for if the student is actually added to the database by the admin
        Blade::if('isStoredStudent', function () {
            $student=Student::where('user_id',Auth::user()->id)->first();

            if($student)
            {
                return true;
            }
            else
            {
                return false;
            }
        });

    }
}
