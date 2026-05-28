<?php

namespace App\Events;

use App\Models\Poll;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PollVoteAcceptedEvent
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public Poll $poll,
    )
    {
    }
}
