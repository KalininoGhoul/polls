<?php

namespace App\Http\Requests\Poll;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\Validation\In;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
class PollIndexRequest extends Data
{
    public function __construct(
        #[In(['name', 'published_at', 'vote_count'])]
        public string $sortBy = 'published_at',
        #[In(['asc', 'desc'])]
        public string $sortDirection = 'desc',
        public int $page = 1,
        #[Max(50)]
        public int $perPage = 10,
    )
    {
    }
}
