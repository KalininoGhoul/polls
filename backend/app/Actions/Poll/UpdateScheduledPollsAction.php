<?php

namespace App\Actions\Poll;

use App\Models\Poll;
use Illuminate\Database\Eloquent\Builder;

class UpdateScheduledPollsAction
{
    public function handle(): void
    {
        Poll::active(false)
            ->where('start_at', '<=', now())
            ->where(
                fn (Builder $q) => $q
                    ->where('end_at', '>', now())
                    ->orWhereNull('end_at')
            )
            ->update([
                'is_active' => true,
                'published_at' => now(),
            ]);

        Poll::where('end_at', '<=', now())
            ->update([
                'is_active' => false,
            ]);
    }
}
