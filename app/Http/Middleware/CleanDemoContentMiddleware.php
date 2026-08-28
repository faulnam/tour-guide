<?php

namespace App\Http\Middleware;

use App\Models\DemoRecord;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\Response;

class CleanDemoContentMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Opportunistic cleanup of expired demo records (> 25 minutes)
        try {
            if (Schema::hasTable('demo_records')) {
                $hasExpired = DemoRecord::where('expires_at', '<=', now())->exists();
                if ($hasExpired) {
                    Artisan::call('demo:clean');
                }
            }
        } catch (\Throwable $e) {
            // ignore if DB is unreachable
        }

        return $next($request);
    }
}
