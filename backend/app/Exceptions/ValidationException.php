<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;

class ValidationException extends AppException
{
    protected int $statusCode = 404;

    protected string $errorCode = 'validation_error';

    public function render(): JsonResponse
    {
        /** @var \Illuminate\Validation\ValidationException $laravelValidationException */
        $laravelValidationException = $this->getPrevious();

        return new JsonResponse([
            'error_code' => $this->errorCode,
            'errors' => $laravelValidationException?->errors() ?? []
        ], 422);
    }
}
