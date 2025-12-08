<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Pastikan user sudah login
        if (!Auth::check()) {
            return redirect()->route('auth.login');
        }

        // 2. Ambil role user saat ini
        $userRole = Auth::user()->role;

        // 3. Cek apakah role user ada di dalam daftar yang diizinkan
        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        // 4. Jika role tidak cocok
        abort(403, 'Akses Ditolak! Role Anda (' . $userRole . ') tidak memiliki izin.');
    }
}