<?php

namespace App\Services\Auth\CodeSenders;

use App\Models\User;

interface AuthCodeSender
{
    public function send(User $user, string $code): bool;
}
