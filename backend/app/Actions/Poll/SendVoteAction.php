<?php

namespace App\Actions\Poll;

use App\Exceptions\Poll\PresentedOptionsNotExistsException;
use App\Exceptions\Poll\TooManyOptionsException;
use App\Exceptions\Poll\UserAlreadyVotedException;
use App\Models\Poll;
use App\Models\PollOption;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class SendVoteAction
{
    public function handle(User $user, Poll $poll, array $options): void
    {
        $preparedOptions = $this->prepareOptions($options);
        $this->validate($user, $poll, $preparedOptions);

        $this->addVotes($user, $poll, $preparedOptions);
    }

    private function validate(User $user, Poll $poll, array $options): void
    {
        if ($this->userAlreadyVoted($user, $poll)) {
            throw new UserAlreadyVotedException();
        }

        if ($this->presentedNotOptionsExists($poll, $options)) {
            throw new PresentedOptionsNotExistsException();
        }

        if ($this->tooManyOptions($poll, $options)) {
            throw new TooManyOptionsException();
        }
    }

    private function prepareOptions(array $options): array
    {
        return collect($options)
            ->unique()
            ->toArray();
    }

    private function userAlreadyVoted(User $user, Poll $poll): bool
    {
        return $poll
            ->votes()
            ->where('user_id', $user->id)
            ->exists();
    }

    private function presentedNotOptionsExists(Poll $poll, array $options): bool
    {
        $optionsCount = $poll
            ->options()
            ->whereIn('id', $options)
            ->count();

        return $optionsCount !== count($options);
    }

    private function tooManyOptions(Poll $poll, array $options): bool
    {
        $maxAnswers = $poll->allow_multiple_answers
            ? $poll->options()->count()
            : 1;

        return count($options) > $maxAnswers;
    }

    private function addVotes(User $user, Poll $poll, array $options): void
    {
        DB::transaction(function () use ($user, $poll, $options) {
            $user->pollOptions()->attach($options);

            PollOption::whereIn('id', $options)
                ->update([
                    'vote_count' => DB::raw('vote_count + 1'),
                ]);

            $poll->vote_count = $poll->vote_count + 1;
            $poll->save();
        });
    }
}
