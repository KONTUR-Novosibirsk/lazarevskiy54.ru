<?php

namespace Modules\News\App\Providers;

use Galtsevt\LaravelSeo\App\Facades\Seo;
use Galtsevt\LaravelSeo\App\Services\Metadata\TemplateSeo;
use Illuminate\Support\Facades\Blade;
use Kontur\Dashboard\App\Modules\Menu\MenuItem;
use Kontur\Dashboard\App\Modules\Module;
use Kontur\Dashboard\App\Modules\ModuleProvider;
use Modules\Menu\App\Facades\MenuBuilder;
use Modules\News\App\Models\News;
use Modules\News\App\Widgets\NewsWidget;

class NewsModuleProvider extends ModuleProvider
{

    protected string $name = 'news';

    protected function init(): void
    {

    }

    protected function getModule(): Module
    {
        return new Module(
            id: 'news',
            name: settings('name', 'news', 'Новости'),
            sidebarItems: [
                new MenuItem(
                    name: settings('name', 'news', 'Новости'),
                    routeName: 'admin.news.index',
                    icon: '<i class="bi bi-newspaper"></i>',
                )
            ],
            widgets: [
                new NewsWidget(),
            ]
        );
    }

    protected function getDir(): string
    {
        return __DIR__;
    }

    protected function registerResources(): void
    {
        Blade::componentNamespace('Modules\\News\\App\\View\\Components', 'news');
        parent::registerResources();
    }

    protected function run(): void
    {
        if ($this->module->isActive()) {
            MenuBuilder::add([
                new \Modules\Menu\App\Models\MenuItem([
                    'name' => settings('name', 'news', 'Новости'),
                    'route_name' => 'news.index',
                ])
            ], 'Модули');

            Seo::template()->add(new TemplateSeo(name: 'Новости', model: News::class));
        }
    }

}
