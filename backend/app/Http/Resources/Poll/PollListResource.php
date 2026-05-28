<?php

namespace App\Http\Resources\Poll;

use App\Models\Poll;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Poll
 */
class PollListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'slug' => $this->slug,
            'name' => $this->name,
            'votes_count' => $this->votes_count ?? 0,
            'image_path' => fileUrl($this->image_path),
        ];
    }
}
