<?php

namespace App\Exceptions\Api;

use Symfony\Component\HttpFoundation\Response;

final class ForbiddenApiException extends ApiException
{
    public function __construct(
        string $message = 'You do not have permission to perform this action.',
        mixed $details = null
    ) {
        parent::__construct(
            'FORBIDDEN',
            $message,
            Response::HTTP_FORBIDDEN,
            $details
        );
    }
}
