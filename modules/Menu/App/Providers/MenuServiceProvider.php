<?php

namespace Modules\Menu\App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Kontur\Dashboard\App\Facades\Modules;
use Kontur\Dashboard\App\Modules\Menu\MenuItem;
use Kontur\Dashboard\App\Modules\Module;
use Modules\Menu\App\Menu\MenuBuilder;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind('app.menu.builder', fn() => new MenuBuilder());
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $module = new Module(
            id: 'menu',
            name: 'Меню',
            sidebarItems: [
                new MenuItem(
                    name: 'Меню',
                    routeName: 'admin.menuBuilder.index',
                    icon: '<i class="bi bi-menu-button-wide-fill"></i>',
                )
            ],
        );
        Modules::register($module);

        Blade::componentNamespace('Modules\\Menu\\App\\View\\Components', 'menu');
        if ($module->isActive()) {
            $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'menu');
            $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
        }

        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');


        $this->publishes([
            __DIR__ . '/../../resources/views' => resource_path('views/vendor/menu'),
        ], 'module-resources');

    }
}
