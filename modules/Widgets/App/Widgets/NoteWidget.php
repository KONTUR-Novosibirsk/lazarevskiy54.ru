<?php

namespace Modules\Widgets\App\Widgets;

use Modules\Widgets\App\Models\WidgetNote;
use Modules\Widgets\App\Resources\WidgetNoteResource;

class NoteWidget extends \Kontur\Dashboard\App\Modules\Widget\AbstractWidget
{

    public function getId(): string
    {
        return 'NoteWidget';
    }

    public function getName(): string
    {
        return 'Заметки';
    }

    public function getData(): array
    {
        return [
            'notes' => WidgetNoteResource::collection(
                WidgetNote::query()->last()->get()
            )
        ];
    }

    public function getDescription(): string
    {
        return 'Виджет заметок';
    }

    public function getParentCssClass(): string
    {
        return '';
    }
}
