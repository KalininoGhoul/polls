<?php

namespace App\Services\Auth;

use App\Exceptions\Auth\AuthCodeInvalid;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginService
{
    public function getToken(LoginRequest $request): string
    {
        $user = User::where('email', $request->email)->first();

        if (is_null($user)) {
            throw new AuthCodeInvalid();
        }

        if (Hash::check($request->code, $user->auth_code)) {
            $user->auth_code = null;
            $user->save();

            return $user->createToken('auth_token')->plainTextToken;
        }

        throw new AuthCodeInvalid();
    }
}
