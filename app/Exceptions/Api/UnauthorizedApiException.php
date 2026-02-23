<?php

namespace App\Exceptions\Api;

use Symfony\Component\HttpFoundation\Response;

final class UnauthorizedApiException extends ApiException
{
    public function __construct(
        string $message = 'Authentication is required.',
        mixed $details = null
    ) {
        parent::__construct(
            'UNAUTHENTICATED',
            $message,
            Response::HTTP_UNAUTHORIZED,
            $details
        );
    }
}
