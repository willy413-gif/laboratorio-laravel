<?php

use App\Helpers\ApiErrorHelper;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectGuestsTo(function (Request $request) {
            if ($request->is('api/*')) {
                throw new \Illuminate\Auth\AuthenticationException();
            }
            return route('login');
        }); //evitar redireccionamiento en peticiones API
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        $exceptions->render(function (AuthenticationException $e, Request $request) {
            return ApiErrorHelper::format(
                false,
                401,
                $e->getMessage() ?: 'No autenticado',
            );
        });

        $exceptions->render(function (Throwable $e, Request $request){

            if($request->is('api/*')){
                $code = $e instanceof HttpException ? $e->getStatusCode() : 500;
                return ApiErrorHelper::format(
                false,
                $code,
                $e->getMessage() ?: 'Error inesperado',
                config('app.debug') ? ['info' => 'Error en línea ' . $e->getLine()] : null
            );
            }
        });
        //
    })->create();
