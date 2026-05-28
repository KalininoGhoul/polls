<?php

use App\Console\Commands\Poll\UpdateScheduledPollsCommand;

Schedule::command(UpdateScheduledPollsCommand::class)->everyMinute();
