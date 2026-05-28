<?php

namespace App\Http\Requests\Poll;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\Validation\ListType;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
class SendVoteRequest extends Data
{
    public function __construct(
        #[ListType]
        #[Min(1)]
        public array $options,
    )
    {
    }
}
