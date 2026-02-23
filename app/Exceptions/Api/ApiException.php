<?php

namespace App\Exceptions\Api;

use App\Support\ApiResponse;
use Exception;
use Illuminate\Http\Request;
use Throwable;

abstract class ApiException extends Exception
{
    public function __construct(
        protected string $errorCode,
        string $message,
        protected int $status,
        protected mixed $details = null,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, 0, $previous);
    }

    public function render(Request $request)
    {
        // Only enforce JSON envelope for API/JSON calls
        if (!$request->expectsJson()) {
            return null; // let Laravel render default
        }

        return ApiResponse::error(
            $this->errorCode,
            $this->getMessage(),
            $this->status,
            $this->details
        );
    }
}
