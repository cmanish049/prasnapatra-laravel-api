<?php

use App\Support\ApiResponse;
use Symfony\Component\HttpFoundation\Response;

describe('ApiResponse::ok()', function (): void {
    test('returns success response with default parameters', function (): void {
        $response = ApiResponse::ok();

        expect($response->status())->toBe(Response::HTTP_OK);
        expect(json_decode($response->getContent(), true))->toBe([
            'success' => true,
            'data' => null,
        ]);
    });

    test('returns success response with custom data', function (): void {
        $data = ['id' => 1, 'name' => 'John'];
        $response = ApiResponse::ok($data);

        expect($response->status())->toBe(Response::HTTP_OK);
        expect(json_decode($response->getContent(), true))->toBe([
            'success' => true,
            'data' => $data,
        ]);
    });

    test('returns success response with custom status code', function (): void {
        $response = ApiResponse::ok(['message' => 'Created'], Response::HTTP_CREATED);

        expect($response->status())->toBe(Response::HTTP_CREATED);
        expect(json_decode($response->getContent(), true))->toBe([
            'success' => true,
            'data' => ['message' => 'Created'],
        ]);
    });

    test('returns response without body for 204 status', function (): void {
        $response = ApiResponse::ok(null, Response::HTTP_NO_CONTENT);

        expect($response->status())->toBe(Response::HTTP_NO_CONTENT);
        expect($response->getContent())->toMatch('/^(\{\}|null)$/');
    });

    test('returns response with status 202 accepted', function (): void {
        $response = ApiResponse::ok(['job_id' => 123], Response::HTTP_ACCEPTED);

        expect($response->status())->toBe(Response::HTTP_ACCEPTED);
        $data = json_decode($response->getContent(), true);
        expect($data['data']['job_id'])->toBe(123);
    });
});

describe('ApiResponse::error()', function (): void {
    test('returns error response with required parameters', function (): void {
        $response = ApiResponse::error('VALIDATION_ERROR', 'Invalid input', Response::HTTP_UNPROCESSABLE_ENTITY);

        expect($response->status())->toBe(Response::HTTP_UNPROCESSABLE_ENTITY);
        expect(json_decode($response->getContent(), true))->toBe([
            'success' => false,
            'error' => [
                'code' => 'VALIDATION_ERROR',
                'message' => 'Invalid input',
            ],
        ]);
    });

    test('returns error response with details', function (): void {
        $details = ['email' => 'Email is required'];
        $response = ApiResponse::error('VALIDATION_ERROR', 'Validation failed', Response::HTTP_UNPROCESSABLE_ENTITY, $details);

        expect($response->status())->toBe(Response::HTTP_UNPROCESSABLE_ENTITY);
        expect(json_decode($response->getContent(), true))->toBe([
            'success' => false,
            'error' => [
                'code' => 'VALIDATION_ERROR',
                'message' => 'Validation failed',
                'details' => $details,
            ],
        ]);
    });

    test('returns unauthorized error', function (): void {
        $response = ApiResponse::error('UNAUTHORIZED', 'Unauthorized access', Response::HTTP_UNAUTHORIZED);

        expect($response->status())->toBe(Response::HTTP_UNAUTHORIZED);
        $data = json_decode($response->getContent(), true);
        expect($data['success'])->toBeFalse();
        expect($data['error']['code'])->toBe('UNAUTHORIZED');
    });

    test('returns not found error', function (): void {
        $response = ApiResponse::error('NOT_FOUND', 'Resource not found', Response::HTTP_NOT_FOUND);

        expect($response->status())->toBe(Response::HTTP_NOT_FOUND);
        $data = json_decode($response->getContent(), true);
        expect($data['error']['message'])->toBe('Resource not found');
    });

    test('does not include details when null', function (): void {
        $response = ApiResponse::error('SERVER_ERROR', 'Internal server error', Response::HTTP_INTERNAL_SERVER_ERROR);

        $data = json_decode($response->getContent(), true);
        expect($data)->not->toHaveKey('error.details');
    });
});
