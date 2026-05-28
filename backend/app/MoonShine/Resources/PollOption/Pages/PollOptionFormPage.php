<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\PollOption\Pages;

use App\MoonShine\Resources\PollOption\PollOptionResource;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\UI\Fields\Text;

/**
 * @extends FormPage<PollOptionResource>
 */
class PollOptionFormPage extends FormPage
{
    protected function fields(): iterable
    {
        return [
            Text::make('Название', 'name')
                ->required(),
        ];
    }
}
