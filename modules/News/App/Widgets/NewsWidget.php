<?php

namespace Modules\News\App\Widgets;

use Modules\News\App\Models\News;
use Modules\News\App\Resources\NewsResource;

class NewsWidget extends \Kontur\Dashboard\App\Modules\Widget\AbstractWidget
{

    public function getId(): string
    {
        return 'LastNews';
    }

    public function getName(): string
    {
        return 'Последние новости';
    }

    public function getData(): array
    {
        return [
            'news' => NewsResource::collection(News::query()->active()->orderBy('publication_date')->limit(7)->get()),
        ];
    }

    public function getDescription(): string
    {
        return 'Последние 5 активных новостей';
    }

    public function getParentCssClass(): string
    {
        return '';
    }
}
