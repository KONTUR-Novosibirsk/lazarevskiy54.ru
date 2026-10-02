<?php

namespace Modules\InfoBlocks\App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Kontur\Dashboard\App\Facades\Modules;
use Kontur\Dashboard\App\Modules\Menu\MenuItem;
use Kontur\Dashboard\App\Modules\Module;
use Modules\InfoBlocks\App\Facades\InfoBlocks;
use Modules\InfoBlocks\App\Services\InfoBlocksContainer;

class InfoBlocksServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind('app.iblock.container', fn() => new InfoBlocksContainer());
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $module = new Module(
            id: 'iblock',
            name: 'Инфо-блоки',
            sidebarItems: [
                new MenuItem(
                    name: 'Инфо-блоки',
                    routeName: 'admin.iblock.index',
                    icon: '<i class="bi bi-boxes"></i>',
                )
            ],
        );
        Modules::register($module);

        if ($module->isActive()) {
            $this->mergeConfigFrom(
                __DIR__ . '/../../config/iblock.php', 'iblock'
            );
            $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
        }

        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        $this->publishes([
            __DIR__ . '/../../config/iblock.php' => config_path('iblock.php'),
        ], 'module-resources');

    }
}
