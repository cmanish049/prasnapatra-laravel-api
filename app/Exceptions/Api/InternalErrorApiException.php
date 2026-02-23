<?php

namespace App\Exceptions\Api;

use Symfony\Component\HttpFoundation\Response;

final class InternalErrorApiException extends ApiException
{
    public function __construct(
        string $message = 'Something went wrong.',
        mixed $details = null
    ) {
        parent::__construct(
            'INTERNAL_ERROR',
            $message,
            Response::HTTP_INTERNAL_SERVER_ERROR,
            $details
        );
    }
}
