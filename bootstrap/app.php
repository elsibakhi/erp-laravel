<?php

use App\Facades\ApiResponse;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        apiPrefix: 'api/v1',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware

            ->group('tenant', [
                \Spatie\Multitenancy\Http\Middleware\NeedsTenant::class,
                // \Spatie\Multitenancy\Http\Middleware\EnsureValidTenantSession::class,
            ])->alias([
                'swap-connection-to' => \App\Http\Middleware\SwapConnectionToMiddleware::class,
            ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (Exception $e, Request $request) {
            // Skip validation exceptions
            if ($e instanceof ValidationException) {
                return null; // Laravel will handle it normally
            }

            if ($request->is('api/*')) {
                $statusCode = method_exists($e, 'getStatusCode')
                    ? $e->getStatusCode()
                    : ($e->getCode() > 0 ? $e->getCode() : 500);

                return ApiResponse::error(
                    $e->getMessage(),
                    config('app.debug') ? ['file' => $e->getFile()] : null,
                    $statusCode
                );
            }
        });
    })->create();
