<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\PollOption\Pages;

use App\MoonShine\Resources\PollOption\PollOptionResource;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\UI\Fields\Text;

/**
 * @extends IndexPage<PollOptionResource>
 */
class PollOptionIndexPage extends IndexPage
{
    protected bool $isLazy = true;

    protected function fields(): iterable
    {
        return [
            Text::make('Название', 'name'),
        ];
    }
}
