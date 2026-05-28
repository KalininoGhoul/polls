<?php

namespace App\Exceptions\Poll;

use App\Exceptions\AppException;

class PresentedOptionsNotExistsException extends AppException
{
    protected int $statusCode = 400;

    protected string $errorCode = 'presented_options_not_exists';
}
