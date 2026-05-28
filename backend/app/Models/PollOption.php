<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PollOption extends Model
{
    protected $table = 'poll_options';

    protected $guarded = ['id'];

    public function votes(): BelongsTo
    {
        return $this->belongsTo(Vote::class, 'poll_option_id');
    }
}
