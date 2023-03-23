<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        
        if(Auth::check())
        {
            if(Auth::user()->role == 1)
            {
                return $next($request);
            }
            else
            {
                return redirect("/")->withErrors("access denied as you are not Admin!");
            }
        }

        else
        {
            return redirect("/login")->withErrors("please login to access to the system");
        }

    }
}
