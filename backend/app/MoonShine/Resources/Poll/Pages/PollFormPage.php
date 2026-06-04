<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Poll\Pages;

use App\Models\Poll;
use App\Models\PollOption;
use App\MoonShine\Resources\Poll\PollResource;
use Illuminate\Validation\Rule;
use MoonShine\CKEditor\Fields\CKEditor;
use MoonShine\Contracts\Core\DependencyInjection\CrudRequestContract;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Crud\JsonResponse;
use MoonShine\Laravel\Fields\Slug;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\Support\Attributes\AsyncMethod;
use MoonShine\Support\ListOf;
use MoonShine\UI\Components\ActionButton;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\Hidden;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Json;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

/**
 * @extends FormPage<PollResource>
 */
class PollFormPage extends FormPage
{
    public function getSubtitle(): string
    {
        return $this->getItem()?->is_active ? 'Активен' : 'Не активен';
    }

    protected function buttons(): ListOf
    {
        return parent::buttons()
            ->add(
                ActionButton::make('Начать')
                    ->method('start')
                    ->canSee(fn() => $this->isItemExists() && !$this->getItem()->is_active),

                ActionButton::make('Завершить')
                    ->method('end')
                    ->canSee(fn() => $this->isItemExists() && $this->getItem()->is_active)
            );
    }

    #[AsyncMethod]
    public function start(CrudRequestContract $request, JsonResponse $response): JsonResponse
    {
        /** @var Poll $poll */
        $poll = $request->getResource()->getItem();

        if (!$poll->is_active) {
            $poll->is_active = true;
            $poll->start_at = now();

            $poll->save();
        }

        return $response->redirect($request->getItemID());
    }

    #[AsyncMethod]
    public function end(CrudRequestContract $request, JsonResponse $response): JsonResponse
    {
        /** @var Poll $poll */
        $poll = $request->getResource()->getItem();

        if ($poll->is_active) {
            $poll->is_active = false;
            $poll->end_at = now();

            $poll->save();
        }

        return $response->redirect($request->getItemID());
    }

    protected function fields(): iterable
    {
        return [
            Grid::make([
                Column::make([
                    Box::make([
                        Text::make('Название', 'name')
                            ->required()
                            ->reactive(),

                        Slug::make('Slug', 'slug')
                            ->from('name')
                            ->unique()
                            ->live(),

                        Image::make('Картинка', 'image_path')
                            ->removable()
                            ->required(fn() => !$this->isItemExists())
                            ->dir('polls'),

                        Switcher::make('Начать сейчас', 'is_active')
                            ->canSee(fn() => !$this->isItemExists()),

                        Grid::make([
                            Column::make([
                                Date::make('Дата начала', 'start_at')
                                    ->withTime()
                                    ->nullable(),
                            ])
                                ->columnSpan(6),

                            Column::make([
                                Date::make('Дата завершения', 'end_at')
                                    ->withTime()
                                    ->nullable(),
                            ])
                                ->columnSpan(6),
                        ])
                    ])
                ])
                    ->columnSpan(6),

                Column::make([
                    Box::make([
                        Switcher::make('Несколько ответов', 'allow_multiple_answers')
                            ->disabled(fn() => !is_null($this->getItem()?->published_at)),

                        Json::make('Опции', 'poll_options')
                            ->creatable(fn() => is_null($this->getItem()?->published_at), Poll::MAX_OPTIONS)
                            ->removable(fn() => is_null($this->getItem()?->published_at))
                            ->reorderable(fn() => is_null($this->getItem()?->published_at))
                            ->required()
                            ->fields([
                                Hidden::make('id'),
                                Text::make('Название', 'name')
                                    ->disabled(fn() => !is_null($this->getItem()?->published_at))
                            ])
                            ->changeFill(fn (Poll $poll) => $poll->options->map(fn (PollOption $option) => [
                                'id' => $option->id,
                                'name' => $option->name,
                            ])),
                    ])
                ])
                    ->columnSpan(6),
            ]),

            Box::make([
                CKEditor::make('Описание', 'description')
                    ->required(),
            ])
        ];
    }

    protected function rules(DataWrapperContract $item): array
    {
        return [
            'image_path' => [
                'sometimes',
                Rule::requiredIf(!request()->has('hidden_image_path')),
            ],
            'start_at' => [
                'nullable',
                'date',
            ],
            'end_at' => [
                'nullable',
                'date',
                'after:start_at'
            ]
        ];
    }
}
