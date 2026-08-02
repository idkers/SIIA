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
        /*
        |--------------------------------------------------------------------------
        | Proxy de Render
        |--------------------------------------------------------------------------
        |
        | Permite que Laravel reconozca correctamente que la conexión pública
        | utiliza HTTPS, aunque Render la reenvíe internamente mediante proxy.
        |
        */

        $middleware->trustProxies(at: '*');

        /*
        |--------------------------------------------------------------------------
        | Redirección de usuarios sin sesión
        |--------------------------------------------------------------------------
        */

        $middleware->redirectGuestsTo(
            fn (Request $request) => route('ingresar')
        );

        /*
        |--------------------------------------------------------------------------
        | Middleware personalizados
        |--------------------------------------------------------------------------
        */

        $middleware->alias([
            'quiz.no.realizado' => \App\Http\Middleware\QuizNoRealizado::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();