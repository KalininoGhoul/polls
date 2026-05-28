<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Poll\Pages;

use App\Models\Poll;
use App\MoonShine\Resources\Poll\PollResource;
use Illuminate\Database\Eloquent\Builder;
use MoonShine\Crud\QueryTags\QueryTag;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\Support\ListOf;
use MoonShine\UI\Components\ActionButton;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Text;

/**
 * @extends IndexPage<PollResource>
 */
class PollIndexPage extends IndexPage
{
    protected bool $isLazy = true;

    protected function fields(): iterable
    {
        return [
            Text::make('Название', 'name'),
            Image::make('Картинка', 'image_path'),
        ];
    }

    protected function queryTags(): array
    {
        return [
            QueryTag::make(
                'Активные',
                static fn(Builder $q) => $q->active()
            ),
            QueryTag::make(
                'Запланированные',
                static fn(Builder $q) => $q->scheduled()
            ),
            QueryTag::make(
                'Завершенные',
                static fn(Builder $q) => $q->closed()
            ),
            QueryTag::make(
                'Удаленные',
                static fn(Builder $q) => $q->onlyTrashed()
            )
        ];
    }

    protected function buttons(): ListOf
    {
        return parent::buttons()->prepend(
            ActionButton::make('Восстановить')
                ->method(
                    'restore',
                    events: [$this->getListEventName()]
                )
                ->canSee(
                    fn(Poll $poll) =>$poll->trashed()
                ),
        );
    }
}
