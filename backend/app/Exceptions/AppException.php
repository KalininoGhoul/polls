<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class AppException extends Exception
{
    protected int $statusCode = 500;

    protected string $errorCode = 'internal_error';

    public function render(): JsonResponse
    {
        return new JsonResponse([
            'error_code' => $this->errorCode,
        ], $this->statusCode);
    }
}
