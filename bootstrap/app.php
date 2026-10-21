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
        // Public AJAX endpoint for Trip Planner.
        // Excluded from CSRF validation so the public demo via ngrok/Google Form
        // does not fail with HTTP 419 when the session cookie/token is not preserved.
        $middleware->validateCsrfTokens(except: [
            'generate-trip',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
