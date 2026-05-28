<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\PollOption;

use App\Models\PollOption;
use App\MoonShine\Resources\PollOption\Pages\PollOptionDetailPage;
use App\MoonShine\Resources\PollOption\Pages\PollOptionFormPage;
use App\MoonShine\Resources\PollOption\Pages\PollOptionIndexPage;
use MoonShine\Laravel\Resources\ModelResource;

/**
 * @extends ModelResource<PollOption>
 */
class PollOptionResource extends ModelResource
{
    protected string $model = PollOption::class;

    protected function pages(): array
    {
        return [
            PollOptionIndexPage::class,
            PollOptionFormPage::class,
            PollOptionDetailPage::class,
        ];
    }
}
