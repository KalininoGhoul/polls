<?php

namespace App\Queries\Poll;

use App\Http\Requests\Poll\PollIndexRequest;
use App\Models\Poll;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class PollIndexQuery
{
    public function __construct(
        private Builder $query,
    )
    {
        $this->query = Poll::query();
    }

    public function filter(PollIndexRequest $request): LengthAwarePaginator
    {
        $this->query->active();

        return $this
            ->addOrderBy($request)
            ->paginate($request);
    }

    private function addOrderBy(PollIndexRequest $request): self
    {
        $this->query->orderBy($request->sortBy, $request->sortDirection);

        return $this;
    }

    private function paginate(PollIndexRequest $request): LengthAwarePaginator
    {
        return $this->query->paginate($request->perPage, page: $request->page);
    }
}
