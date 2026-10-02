<?php

namespace Modules\Widgets\App\Widgets;

class AboutWidget extends \Kontur\Dashboard\App\Modules\Widget\AbstractWidget
{

    public function getId(): string
    {
        return 'AboutWidget';
    }

    public function getName(): string
    {
        return 'Краткая информация о KonturCMS';
    }

    public function getData(): array
    {
        return [];
    }

    public function getDescription(): string
    {
        return 'Виджет с краткой информацией о компании Kontur';
    }

    public function getParentCssClass(): string
    {
        return 'text-bg-dark';
    }
}
