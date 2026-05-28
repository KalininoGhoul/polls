<?php

namespace App\Exceptions;

class NotFoundException extends AppException
{
    protected int $statusCode = 404;

    protected string $errorCode = 'not_found';
}
