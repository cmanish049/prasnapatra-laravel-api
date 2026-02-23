<?php

namespace App\Exceptions\Api;

use Symfony\Component\HttpFoundation\Response;

final class ConflictApiException extends ApiException
{
    public function __construct(
        string $message = 'Conflict.',
        mixed $details = null
    ) {
        parent::__construct(
            'CONFLICT',
            $message,
            Response::HTTP_CONFLICT,
            $details
        );
    }
}
