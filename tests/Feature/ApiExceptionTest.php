<?php

use App\Exceptions\Api\ConflictApiException;
use App\Exceptions\Api\ForbiddenApiException;
use App\Exceptions\Api\InternalErrorApiException;
use App\Exceptions\Api\NotFoundApiException;
use App\Exceptions\Api\RateLimitedApiException;
use App\Exceptions\Api\UnauthorizedApiException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

describe('API exceptions', function (): void {
    test('returns null for non-json requests', function (): void {
        $request = Request::create('/web', 'GET');
        $request->headers->set('Accept', 'text/html');

        $exception = new ConflictApiException();

        expect($exception->render($request))->toBeNull();
    });

    test('renders json envelope for api exceptions', function (string $exceptionClass, string $errorCode, int $status, string $message): void {
        $request = Request::create('/api/test', 'GET');
        $request->headers->set('Accept', 'application/json');

        $exception = new $exceptionClass();
        $response = $exception->render($request);

        expect($response->status())->toBe($status);
        expect(json_decode((string) $response->getContent(), true))->toBe([
            'success' => false,
            'error' => [
                'code' => $errorCode,
                'message' => $message,
            ],
        ]);
    })->with('apiExceptionDefaults');

    test('renders json envelope with details', function (string $exceptionClass, string $errorCode, int $status): void {
        $request = Request::create('/api/test', 'GET');
        $request->headers->set('Accept', 'application/json');

        $details = ['field' => 'email'];
        $exception = new $exceptionClass('Custom message.', $details);
        $response = $exception->render($request);

        expect($response->status())->toBe($status);
        expect(json_decode((string) $response->getContent(), true))->toBe([
            'success' => false,
            'error' => [
                'code' => $errorCode,
                'message' => 'Custom message.',
                'details' => $details,
            ],
        ]);
    })->with('apiExceptionDetails');
});

dataset('apiExceptionDefaults', fn (): array => [
    'conflict' => [
        ConflictApiException::class,
        'CONFLICT',
        Response::HTTP_CONFLICT,
        'Conflict.',
    ],
    'forbidden' => [
        ForbiddenApiException::class,
        'FORBIDDEN',
        Response::HTTP_FORBIDDEN,
        'You do not have permission to perform this action.',
    ],
    'internal-error' => [
        InternalErrorApiException::class,
        'INTERNAL_ERROR',
        Response::HTTP_INTERNAL_SERVER_ERROR,
        'Something went wrong.',
    ],
    'not-found' => [
        NotFoundApiException::class,
        'RESOURCE_NOT_FOUND',
        Response::HTTP_NOT_FOUND,
        'Resource not found.',
    ],
    'rate-limited' => [
        RateLimitedApiException::class,
        'RATE_LIMITED',
        Response::HTTP_TOO_MANY_REQUESTS,
        'Too many requests. Please try again later.',
    ],
    'unauthorized' => [
        UnauthorizedApiException::class,
        'UNAUTHENTICATED',
        Response::HTTP_UNAUTHORIZED,
        'Authentication is required.',
    ],
]);

dataset('apiExceptionDetails', fn (): array => [
    'conflict' => [
        ConflictApiException::class,
        'CONFLICT',
        Response::HTTP_CONFLICT,
    ],
    'forbidden' => [
        ForbiddenApiException::class,
        'FORBIDDEN',
        Response::HTTP_FORBIDDEN,
    ],
    'internal-error' => [
        InternalErrorApiException::class,
        'INTERNAL_ERROR',
        Response::HTTP_INTERNAL_SERVER_ERROR,
    ],
    'not-found' => [
        NotFoundApiException::class,
        'RESOURCE_NOT_FOUND',
        Response::HTTP_NOT_FOUND,
    ],
    'rate-limited' => [
        RateLimitedApiException::class,
        'RATE_LIMITED',
        Response::HTTP_TOO_MANY_REQUESTS,
    ],
    'unauthorized' => [
        UnauthorizedApiException::class,
        'UNAUTHENTICATED',
        Response::HTTP_UNAUTHORIZED,
    ],
]);
