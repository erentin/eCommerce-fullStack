<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $allowedEmails = ["erentin@outlook.com","info@ketencek.com"];
        $userEmail = Auth::user()->email;

        if (Auth::check() && in_array($userEmail,$allowedEmails) ) {
            return $next($request);
        }
        
        return redirect()->route('home');
    }
}
