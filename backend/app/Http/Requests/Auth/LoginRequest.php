<?php

namespace App\Http\Requests\Auth;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MergeValidationRules;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MergeValidationRules]
class LoginRequest extends Data
{
    public function __construct(
        #[Email]
        public string $email,
        public string $code,
    )
    {
    }
}
