<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\checklogin;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\CheckVerifiedEmail;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        //$middleware->append(checklogin::class); this is redirecting again and again

        //highly recomended to use it in middlewares
        $middleware->alias([
            'validuser' => checklogin::class,
             'ifvaliduser'=>RedirectIfAuthenticated::class,
             'emailverified'=>CheckVerifiedEmail::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();



