<?php

namespace Modules\Widgets\App\Providers;

use Illuminate\Support\ServiceProvider;
use Kontur\Dashboard\App\Facades\Modules;
use Kontur\Dashboard\App\Modules\Module;
use Modules\Widgets\App\Widgets\AboutWidget;
use Modules\Widgets\App\Widgets\NoteWidget;

class WidgetServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $module = new Module(
            id: 'widgets',
            name: 'Набор виджетов',
            widgets: [
                new AboutWidget(),
                new NoteWidget(),
            ]
        );
        Modules::register($module);
        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

    }
}
