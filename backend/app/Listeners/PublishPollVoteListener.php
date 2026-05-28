<?php

namespace App\Listeners;

use App\Events\PollVoteAcceptedEvent;
use App\Http\Resources\Poll\PollOptionListResource;
use App\Models\PollOption;
use App\Services\Centrifugal\CentrifugalClient\CentrifugalClient;
use App\Services\Centrifugal\CentrifugalClient\Dto\Publish\PublishRequest;

class PublishPollVoteListener
{
    public function __construct(
        private CentrifugalClient $centrifugalClient,
    )
    {
    }

    public function handle(PollVoteAcceptedEvent $event): void
    {
        $this->centrifugalClient->publish(new PublishRequest(
            channel: $event->poll->slug,
            data: [
                'vote_count' => $event->poll->vote_count,
                'options' => PollOptionListResource::collection($event->poll->options),
            ]
        ));
    }
}
