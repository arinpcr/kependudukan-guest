<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckIsLogin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Jika User BELUM Login
        if (!Auth::check()) {
            // Arahkan ke route bernama 'auth.login'
            return redirect()->route('auth.login')->withErrors(['email' => 'Silahkan login terlebih dahulu!']);
        }

        return $next($request);
    }
}