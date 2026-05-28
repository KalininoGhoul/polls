<?php

namespace App\Services\Centrifugal\CentrifugalClient;

use App\Services\Centrifugal\CentrifugalClient\Dto\Publish\PublishRequest;
use Illuminate\Http\Client\PendingRequest;
use Psr\Log\LoggerInterface;

class CentrifugalHttpClient implements CentrifugalClient
{
    public function __construct(
        private PendingRequest $httpClient,
        private LoggerInterface $logger,
    )
    {
    }

    public function publish(PublishRequest $request): bool
    {
        $response = $this->httpClient->post('/publish', [
            'channel' => $request->channel,
            'data' => $request->data,
        ]);

        if ($response->failed()) {
            $this->logger->error('Publish failed', ['error' => $response->json()]);
        }

        return $response->successful();
    }
}
