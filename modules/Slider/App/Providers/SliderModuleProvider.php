<?php

namespace Modules\Slider\App\Providers;

use Illuminate\Support\Facades\Blade;
use Kontur\Dashboard\App\Modules\Menu\MenuItem;
use Kontur\Dashboard\App\Modules\Module;
use Kontur\Dashboard\App\Modules\ModuleProvider;

class SliderModuleProvider extends ModuleProvider
{
    protected string $name = 'slider';

    protected function init(): void
    {
        // TODO: Implement init() method.
    }

    protected function run(): void
    {
        // TODO: Implement run() method.
    }

    protected function registerResources(): void
    {
        Blade::componentNamespace('Modules\\Slider\\App\\View\\Components', $this->name);
        parent::registerResources();
    }

    protected function getModule(): Module
    {
        return new Module(
            id: 'slider',
            name: 'Слайдер',
            sidebarItems: [
                new MenuItem(
                    name: 'Слайдер',
                    routeName: 'admin.slider.index',
                    icon: '<i class="bi bi-aspect-ratio-fill"></i>',
                )
            ],
            widgets: [
            ]
        );
    }

    protected function getDir(): string
    {
        return __DIR__;
    }
}
