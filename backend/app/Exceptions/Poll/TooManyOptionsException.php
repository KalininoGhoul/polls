<?php

namespace App\Exceptions\Poll;

use App\Exceptions\AppException;

class TooManyOptionsException extends AppException
{
    protected int $statusCode = 400;

    protected string $errorCode = 'too_many_options';
}
