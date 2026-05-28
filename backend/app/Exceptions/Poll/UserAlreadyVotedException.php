<?php

namespace App\Exceptions\Poll;

use App\Exceptions\AppException;

class UserAlreadyVotedException extends AppException
{
    protected int $statusCode = 400;

    protected string $errorCode = 'user_already_voted';
}
