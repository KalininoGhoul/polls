<?php

namespace App\Actions\Auth;

use App\Enums\Auth\AuthCodeType;
use App\Http\Requests\Auth\SendCodeRequest;
use App\Models\User;
use App\Services\Auth\CodeGenerators\AuthCodeGenerator;
use App\Services\Auth\CodeGenerators\TestAuthCodeGenerator;
use App\Services\Auth\CodeSenders\AuthCodeSender;
use App\Services\Auth\CodeSenders\LogAuthCodeSender;
use App\Services\Auth\CodeSenders\MailAuthCodeSender;

class SendAuthCodeAction
{
    public function handle(SendCodeRequest $request): void
    {
        $code = $this->getCodeGenerator($request->codeType)->generate();

        $user = $this->getUser($request->email);

        $user->auth_code = $code;
        $user->save();

        $this->getCodeSender($request->codeType)->send($user, $code);
    }

    private function getUser(string $email): User
    {
        return User::firstOrCreate([
            'email' => $email,
        ]);
    }

    private function getCodeGenerator(AuthCodeType $authCodeType): AuthCodeGenerator
    {
        $class = match ($authCodeType) {
            AuthCodeType::TEST => TestAuthCodeGenerator::class,
            default => AuthCodeGenerator::class,
        };

        return app($class);
    }

    private function getCodeSender(AuthCodeType $authCodeType): AuthCodeSender
    {
        $class = match ($authCodeType) {
            AuthCodeType::TEST => LogAuthCodeSender::class,
            AuthCodeType::MAIL => MailAuthCodeSender::class,
        };

        return app($class);
    }
}
