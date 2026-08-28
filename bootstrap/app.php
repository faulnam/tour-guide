<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(at: '*');

        $middleware->redirectTo(
            guests: '/login',
        );

        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminOnly::class,
            'karyawan' => \App\Http\Middleware\KaryawanOnly::class,
            'customer' => \App\Http\Middleware\CustomerOnly::class,
        ]);

        $middleware->append(\App\Http\Middleware\CleanDemoContentMiddleware::class);

        $middleware->validateCsrfTokens(except: [
            'chatbot/*',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
