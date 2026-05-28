<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Poll;

use App\Models\Poll;
use App\MoonShine\Handlers\PollSaveHandler;
use App\MoonShine\Resources\Poll\Pages\PollDetailPage;
use App\MoonShine\Resources\Poll\Pages\PollFormPage;
use App\MoonShine\Resources\Poll\Pages\PollIndexPage;
use MoonShine\Crud\Attributes\SaveHandler;
use MoonShine\Laravel\Resources\ModelResource;

/**
 * @extends ModelResource<Poll, PollIndexPage, PollFormPage, PollDetailPage>
 */
#[SaveHandler(PollSaveHandler::class)]
class PollResource extends ModelResource
{
    protected string $model = Poll::class;

    protected string $title = 'Опросы';

    protected function pages(): array
    {
        return [
            PollIndexPage::class,
            PollFormPage::class,
            PollDetailPage::class,
        ];
    }
}
