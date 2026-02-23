<?php

namespace App\Exceptions\Api;

use Symfony\Component\HttpFoundation\Response;

final class RateLimitedApiException extends ApiException
{
    public function __construct(
        string $message = 'Too many requests. Please try again later.',
        mixed $details = null
    ) {
        parent::__construct(
            'RATE_LIMITED',
            $message,
            Response::HTTP_TOO_MANY_REQUESTS,
            $details
        );
    }
}
