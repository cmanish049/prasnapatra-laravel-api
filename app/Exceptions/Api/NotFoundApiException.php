<?php

namespace App\Exceptions\Api;

use Symfony\Component\HttpFoundation\Response;

final class NotFoundApiException extends ApiException
{
    public function __construct(
        string $message = 'Resource not found.',
        mixed $details = null
    ) {
        parent::__construct(
            'RESOURCE_NOT_FOUND',
            $message,
            Response::HTTP_NOT_FOUND,
            $details
        );
    }
}
