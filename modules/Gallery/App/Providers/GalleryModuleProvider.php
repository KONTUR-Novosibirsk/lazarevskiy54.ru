<?php

namespace Modules\Gallery\App\Providers;

use Illuminate\Support\Facades\Blade;
use Kontur\Dashboard\App\Modules\Menu\MenuItem;
use Kontur\Dashboard\App\Modules\Module;
use Kontur\Dashboard\App\Modules\ModuleProvider;
use Modules\Menu\App\Facades\MenuBuilder;

class GalleryModuleProvider extends ModuleProvider
{

    protected string $name = 'gallery';

    protected function registerResources(): void
    {
        Blade::componentNamespace('Modules\\Gallery\\App\\View\\Components', 'gallery');
        parent::registerResources();
    }

    protected function init(): void
    {
        // TODO: Implement init() method.
    }

    protected function run(): void
    {
        MenuBuilder::add([
            new \Modules\Menu\App\Models\MenuItem([
                'name' => settings('name', 'gallery', 'Фотогалерея'),
                'route_name' => 'gallery.index',
            ])
        ], 'Модули');
    }

    protected function getModule(): Module
    {
        return new Module(
            id: 'gallery',
            name: settings('name', 'gallery', 'Фотогалерея'),
            sidebarItems: [
                new MenuItem(
                    name: settings('name', 'gallery', 'Фотогалерея'),
                    routeName: 'admin.gallery.index',
                    icon: '<i class="bi bi-images"></i>',
                )
            ],
        );
    }

    protected function getDir(): string
    {
        return __DIR__;
    }
}
