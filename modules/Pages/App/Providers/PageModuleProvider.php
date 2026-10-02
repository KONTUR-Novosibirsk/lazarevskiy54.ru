<?php

namespace Modules\Pages\App\Providers;

use Kontur\Dashboard\App\Facades\Modules;
use Kontur\Dashboard\App\Modules\Menu\MenuItem;
use Kontur\Dashboard\App\Modules\Module;
use Kontur\Dashboard\App\Modules\ModuleProvider;
use Modules\Menu\App\Facades\MenuBuilder;
use Modules\Pages\App\Models\Page;

class PageModuleProvider extends ModuleProvider
{
    protected string $name = 'page';

    protected function init(): void
    {
        // TODO: Implement init() method.
    }

    protected function run(): void
    {
        if ($this->isDashboard()) {
            try {
                $pages = Page::query()->active()->get();
                foreach ($pages as $item) {
                    MenuBuilder::add([
                        new \Modules\Menu\App\Models\MenuItem([
                            'name' => $item->title,
                            'route_name' => 'page.show',
                            'model_type' => Page::class,
                            'model_id' => $item->id,
                            'route_attributes' => ['alias' => $item->alias],
                        ])
                    ], 'Страницы');
                }
            } catch (\Exception $exception) {

            }
        }
    }

    protected function getModule(): Module
    {
        return new Module(
            id: 'page',
            name: 'Страницы',
            sidebarItems: [
                new MenuItem(
                    name: 'Страницы',
                    routeName: 'admin.page.index',
                    icon: '<i class="bi bi-receipt"></i>',
                )
            ],
        );
    }

    protected function getDir(): string
    {
        return __DIR__;
    }
}
