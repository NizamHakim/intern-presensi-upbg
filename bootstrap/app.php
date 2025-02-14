<?php

use App\Http\Middleware\AjaxSessionHandler;
use App\Http\Middleware\Authenticated;
use App\Http\Middleware\VerifyOwnership;
use App\Http\Middleware\VerifyRole;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->priority([
          Authenticated::class,
          VerifyRole::class,
          VerifyOwnership::class,
          VerifyCsrfToken::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
