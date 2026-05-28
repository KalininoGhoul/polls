<?php

declare(strict_types=1);

namespace App\MoonShine\Handlers;

use App\Models\Poll;
use App\Models\PollOption;
use Illuminate\Support\Facades\DB;

class PollSaveHandler
{
    public function __invoke(Poll $poll, array $data): Poll
    {
        DB::transaction(function () use ($poll, $data) {
            $poll->name = $data['name'];
            $poll->image_path = $data['image_path'];
            $poll->description = $data['description'];
            $poll->allow_multiple_answers = $data['allow_multiple_answers'];
            $poll->is_active = $data['is_active'];
            $poll->start_at = $data['start_at'];
            $poll->end_at = $data['end_at'];

            if (is_null($poll->published_at) && $poll->is_active) {
                $poll->start_at = $poll->published_at = now();
            }

            unset($poll->poll_options);

            $poll->save();

            $actualOptions = collect($data['poll_options']);
            $oldOptions = $poll->options;

            PollOption::whereIn('id', $oldOptions
                ->pluck('id')
                ->diff($actualOptions->pluck('id'))
            )
                ->delete();

            foreach ($actualOptions as $key => $option) {
                if (isset($option['id'])) {
                    $poll->options()->where('id', $option['id'])->update([
                        'order' => $key,
                        'name' => $option['name'],
                    ]);

                    continue;
                }

                $poll->options()->create([
                    'order' => $key,
                    'name' => $option['name'],
                ]);
            }
        });

        return $poll;
    }
}
