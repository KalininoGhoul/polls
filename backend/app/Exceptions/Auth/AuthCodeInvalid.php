<?php

namespace App\Exceptions\Auth;

use App\Exceptions\AppException;

class AuthCodeInvalid extends AppException
{
    protected int $statusCode = 400;

    protected string $errorCode = 'auth_code_invalid';
}
