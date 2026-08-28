<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminOnly
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan masuk terlebih dahulu untuk mengakses panel admin.');
        }

        if (!Auth::user()->isAdmin()) {
            return redirect()->route('login')->with('error', 'Anda tidak memiliki hak akses administrator.');
        }

        return $next($request);
    }
}
