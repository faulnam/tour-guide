<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class KaryawanOnly
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan masuk terlebih dahulu untuk mengakses portal karyawan.');
        }

        if (!Auth::user()->isKaryawan() && !Auth::user()->isAdmin()) {
            return redirect()->route('login')->with('error', 'Akses khusus untuk Karyawan dan Teknisi Bengkel.');
        }

        return $next($request);
    }
}
