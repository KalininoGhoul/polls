<?php

namespace App\Services\Auth\CodeSenders;

use App\Mail\AuthCodeMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class MailAuthCodeSender implements AuthCodeSender
{
    public function send(User $user, string $code): bool
    {
        Mail::to($user->email)->send(new AuthCodeMail($code));

        return true;
    }
}
