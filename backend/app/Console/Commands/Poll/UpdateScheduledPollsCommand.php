<?php

namespace App\Console\Commands\Poll;

use App\Actions\Poll\UpdateScheduledPollsAction;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('polls:update-scheduled')]
class UpdateScheduledPollsCommand extends Command
{
    public function handle(UpdateScheduledPollsAction $updateScheduledPollsAction): void
    {
        $updateScheduledPollsAction->handle();

        $this->info('Polls have been updated');
    }
}
