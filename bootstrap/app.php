<?php

use App\Notifications\ErrorOccurred;
use Illuminate\Contracts\Notifications\Dispatcher;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: [
            __DIR__.'/../routes/fortify.php',
            __DIR__.'/../routes/waybill.php',
            __DIR__.'/../routes/admin.php',
            __DIR__.'/../routes/web.php',
            __DIR__.'/../routes/cart.php',
        ],
        api: [
            __DIR__.'/../routes/api.php',
        ],
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Register route middleware aliases
        $middleware->alias([
            'localization' => \App\Http\Middleware\localization::class,
            'role' => Spatie\Permission\Middleware\RoleMiddleware::class,
            'auth' => \App\Http\Middleware\Authenticate::class,
            'cartToken' => \App\Http\Middleware\CartTokenMiddleware::class,
            'user.lock' => \App\Http\Middleware\SimpleLockMiddleware::class,
            'any.lock' => \App\Http\Middleware\LockAnyUntillFirstMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        $exceptions->report(function (Throwable $exception) {

            if (app()->runningInConsole()) {
                return;
            }

            if (! app()->bound(Dispatcher::class)) {
                return;
            }

            Notification::route('mail', 'shopzgestore@gmail.com')
                ->notify(
                    new ErrorOccurred(
                        $exception,
                        request()?->user()
                    )
                );
        });
    })->create();
