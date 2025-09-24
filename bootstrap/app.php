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
   ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'adminAuth' => \App\Http\Middleware\AdminAuth::class,
            'userAuth' => \App\Http\Middleware\UserAuth::class,
            'guest' => \App\Http\Middleware\Guest::class,
            'xss' => \App\Http\Middleware\XSS::class,  
            'apiAuth' => \App\Http\Middleware\ApiAuth::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
