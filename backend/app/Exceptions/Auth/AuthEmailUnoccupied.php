<?php

namespace App\Exceptions\Auth;

use App\Exceptions\AppException;

class AuthEmailUnoccupied extends AppException
{
    protected int $statusCode = 400;

    protected string $errorCode = 'auth_email_unoccupied';
}
