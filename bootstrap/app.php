<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Exempt payment gateway callbacks from CSRF verification (they come from external gateway)
        $middleware->validateCsrfTokens(except: [
            'payment/success',
            'payment/fail',
            'payment/cancel',
        ]);
        
        $middleware->alias([
            'official' => \App\Http\Middleware\EnsureOfficial::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
