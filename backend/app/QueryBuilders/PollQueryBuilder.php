<?php

namespace App\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class PollQueryBuilder extends Builder
{
    public function active(bool $value = true): self
    {
        return $this->where('is_active', $value);
    }

    public function scheduled(): self
    {
        return $this->where('start_at', '>', now());
    }

    public function closed(): self
    {
        return $this
            ->where('is_active', false)
            ->where(
                fn (Builder $q) => $q
                    ->whereNull('start_at')
                    ->orWhere('start_at', '<', now())
            )
            ->where(
                fn (Builder $q) => $q
                    ->whereNull('end_at')
                    ->orWhere('end_at', '<', now())
            );
    }
}
