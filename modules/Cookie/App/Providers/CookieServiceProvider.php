<?php

namespace Modules\Cookie\App\Providers;

use Illuminate\Support\Facades\Blade;
use Kontur\Dashboard\App\Modules\Menu\MenuItem;
use Kontur\Dashboard\App\Modules\Module;
use Modules\Menu\App\Facades\MenuBuilder;
use Kontur\Dashboard\App\Modules\ModuleProvider;

class CookieServiceProvider extends ModuleProvider
{

    protected string $name = 'cookie';

    protected function registerResources(): void
    {
        Blade::componentNamespace('Modules\\Cookie\\App\\View\\Components', 'cookie');
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
                'name' => settings('name', 'cookie', 'Куки'),
                'route_name' => 'cookie.index',
            ])
        ], 'Модули');
    }

    protected function getModule(): Module
    {
        return new Module(
            id: 'cookie',
            name: settings('name', 'cookie', 'Куки'),
            sidebarItems: [
                new MenuItem(
                    name: settings('name', 'cookie', 'Куки'),
                    routeName: 'admin.cookie.index',
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
