<?php

use Illuminate\Http\JsonResponse;
use App\Support\ApiResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // 422 Validation
        $exceptions->render(function (ValidationException $e, $request): ?JsonResponse {
            if (!$request->expectsJson()) {
                return null;
            }

            return ApiResponse::error(
                'VALIDATION_ERROR',
                'Validation failed.',
                422,
                ['fields' => $e->errors()]
            );
        });

        // 401 Unauthenticated (Sanctum missing/invalid token)
        $exceptions->render(function (AuthenticationException $e, $request): ?JsonResponse {
            if (!$request->expectsJson()) {
                return null;
            }

            return ApiResponse::error(
                'UNAUTHENTICATED',
                'Authentication is required.',
                401
            );
        });

        // 403 Forbidden (policies/gates)
        $exceptions->render(function (AuthorizationException $e, $request): ?JsonResponse {
            if (!$request->expectsJson()) {
                return null;
            }

            return ApiResponse::error(
                'FORBIDDEN',
                'You do not have permission to perform this action.',
                403
            );
        });

        // 404 Model not found (route-model binding)
        $exceptions->render(function (ModelNotFoundException $e, $request): ?JsonResponse {
            if (!$request->expectsJson()) {
                return null;
            }

            return ApiResponse::error(
                'RESOURCE_NOT_FOUND',
                'Resource not found.',
                404
            );
        });

        // 429 Rate limit
        $exceptions->render(function (ThrottleRequestsException $e, $request): ?JsonResponse {
            if (!$request->expectsJson()) {
                return null;
            }

            $headers = method_exists($e, 'getHeaders') ? $e->getHeaders() : [];
            $retryAfter = $headers['Retry-After'] ?? null;

            return ApiResponse::error(
                'RATE_LIMITED',
                'Too many requests. Please try again later.',
                429,
                $retryAfter ? ['retry_after_seconds' => (int) $retryAfter] : null
            );
        });

        // Route 404 / 405 / other Http exceptions
        $exceptions->render(function (HttpExceptionInterface $e, $request): ?JsonResponse {
            if (!$request->expectsJson()) {
                return null;
            }

            $status = $e->getStatusCode();

            return match ($status) {
                404 => ApiResponse::error('NOT_FOUND', 'Endpoint not found.', 404),
                405 => ApiResponse::error('METHOD_NOT_ALLOWED', 'Method not allowed.', 405),
                default => ApiResponse::error('HTTP_ERROR', 'Request failed.', $status),
            };
        });

        // Fallback 500 (don’t leak details)
        $exceptions->render(function (Throwable $e, $request): ?JsonResponse {
            if (!$request->expectsJson()) {
                return null;
            }

            report($e);

            return ApiResponse::error(
                'INTERNAL_ERROR',
                'Something went wrong.',
                500
            );
        });
    })->create();
