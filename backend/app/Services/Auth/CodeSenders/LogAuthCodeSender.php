<?php

namespace App\Services\Auth\CodeSenders;

use App\Models\User;
use Psr\Log\LoggerInterface;

class LogAuthCodeSender implements AuthCodeSender
{
    public function __construct(
        private LoggerInterface $logger,
    )
    {
    }

    public function send(User $user, string $code): bool
    {
        $this->logger->info("Auth code: {$code}");

        return true;
    }
}
