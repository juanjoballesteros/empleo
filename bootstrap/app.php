<?php

declare(strict_types=1);

use App\Http\Middleware\EnsureCvIsCompleted;
use App\Http\Middleware\EnsureCvIsCreated;
use App\Http\Middleware\EnsureTypeIsRegistered;
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
        $middleware->alias([
            'type' => EnsureTypeIsRegistered::class,
            'cv' => EnsureCvIsCompleted::class,
            'cv_created' => EnsureCvIsCreated::class,
        ]);

        $middleware->validateCsrfTokens(except: [
            'whatsapp',
            'whatsapp/*',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
