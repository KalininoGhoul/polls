<?php

namespace App\Http\Requests\Auth;

use App\Enums\Auth\AuthCodeType;
use Illuminate\Validation\Rule;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MergeValidationRules;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Spatie\LaravelData\Support\Validation\ValidationContext;

#[MapInputName(SnakeCaseMapper::class)]
#[MergeValidationRules]
class SendCodeRequest extends Data
{
    public function __construct(
        #[Email]
        public string $email,
        public AuthCodeType $codeType,
    )
    {
    }

    public static function rules(?ValidationContext $context = null): array
    {
        $except = [];

        if (app()->environment() === 'production') $except[] = AuthCodeType::TEST;

        return [
            'email' => ['required'],
            'auth_code_type' => [
                Rule::enum(AuthCodeType::class)->except($except),
            ],
        ];
    }
}
