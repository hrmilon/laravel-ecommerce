<?php

use App\Http\Middleware\AdminAccessedRoute;
use App\Http\Middleware\AuthCheck;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use phpDocumentor\Reflection\PseudoTypes\False_;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        AdminAccessedRoute::class;
        AuthCheck::class;

    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (AccessDeniedHttpException $e) {
            return response()->json([
                "message" => "you are not allowed to perform this task"
            ], 429);
        });
        $exceptions->render(function (NotFoundHttpException $e) {
            return response()->json([
                "message" => "The resource has not been found on this server"
            ], 404);
        });
    })->create();
