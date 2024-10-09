<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withExceptions(function ($exceptions) {
        $exceptions->setDefaultHandler(function ($request, $exception) {
            if ($exception instanceof ValidationException) {
                return new JsonResponse([
                    'error' => 'Dados inválidos',
                    'messages' => $exception->validator->errors(),
                ], 422);
            }

            return new JsonResponse([
                'error' => 'Ocorreu um erro',
                'message' => $exception->getMessage(),
            ], 500);
        });
    })
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
