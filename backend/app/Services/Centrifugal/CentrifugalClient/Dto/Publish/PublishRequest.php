<?php

namespace App\Services\Centrifugal\CentrifugalClient\Dto\Publish;

class PublishRequest
{
    public function __construct(
        public string $channel,
        public array $data,
    )
    {
    }
}
