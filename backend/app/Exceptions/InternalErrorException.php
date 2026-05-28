<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class InternalErrorException extends AppException
{
    protected string $errorCode = 'internal_error';

    public function render(): JsonResponse
    {
        return new JsonResponse(config('app.debug') ? [
            'error_code' => $this->errorCode,
            'message' => $this->getPrevious()->getMessage(),
            'exception' => get_class($this->getPrevious()),
            'file' => $this->getPrevious()->getFile(),
            'line' => $this->getPrevious()->getLine(),
            'trace' => (new Collection($this->getPrevious()->getTrace()))->map(fn ($trace) => Arr::except($trace, ['args']))->all(),
        ] : [
            'error_code' => 'internal_error',
        ], 500);
    }
}
