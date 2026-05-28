<?php

namespace App\Models;

use App\QueryBuilders\PollQueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Poll extends Model
{
    use SoftDeletes;

    public const int MAX_OPTIONS = 10;

    protected $table = 'polls';

    protected $guarded = ['id'];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'published_at' => 'datetime',
    ];

    public function newEloquentBuilder($query): PollQueryBuilder
    {
        return new PollQueryBuilder($query);
    }

    public function options(): HasMany
    {
        return $this->hasMany(PollOption::class, 'poll_id');
    }

    public function votes(): HasManyThrough
    {
        return $this->hasManyThrough(Vote::class, PollOption::class, 'poll_id', 'poll_option_id');
    }
}
