<?php

namespace App\Services\Centrifugal\CentrifugalClient;

use App\Services\Centrifugal\CentrifugalClient\Dto\Publish\PublishRequest;

interface CentrifugalClient
{
    public function publish(PublishRequest $request): bool;
}
