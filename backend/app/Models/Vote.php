<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vote extends Model
{
    protected $table = 'votes';

    protected $guarded = ['id'];

    public function option(): BelongsTo
    {
        return $this->belongsTo(PollOption::class, 'poll_id');
    }
}
