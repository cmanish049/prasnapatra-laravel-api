<?php

namespace App\Support;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ApiResponse
{
    public static function ok(mixed $data = null, int $status = Response::HTTP_OK): JsonResponse
    {
        // 204 should not return a body
        if ($status === Response::HTTP_NO_CONTENT) {
            return response()->json(null, $status);
        }

        return response()->json([
            'success' => true,
            'data' => $data,
        ], $status);
    }

    public static function error(
        string $code,
        string $message,
        int $status,
        mixed $details = null
    ): JsonResponse {
        $payload = [
            'success' => false,
            'error' => [
                'code' => $code,
                'message' => $message,
            ],
        ];

        if ($details !== null) {
            $payload['error']['details'] = $details;
        }

        return response()->json($payload, $status);
    }
}
