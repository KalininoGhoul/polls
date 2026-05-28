<?php

namespace App\Http\Resources\Poll;

use App\Models\PollOption;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin PollOption
 */
class PollOptionListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'vote_count' => $this->vote_count,
        ];
    }
}
