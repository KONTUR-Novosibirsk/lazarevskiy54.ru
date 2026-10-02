<?php

namespace Kontur\Dashboard\App\Providers;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Kontur\Dashboard\App\Commands\MakeModuleCommand;
use Kontur\Dashboard\App\Facades\Modules;
use Kontur\Dashboard\App\Middleware\AdminMiddleware;
use Kontur\Dashboard\App\Middleware\DevAdminMiddleware;
use Kontur\Dashboard\App\Middleware\ModuleCheckActive;
use Kontur\Dashboard\App\Modules\ModulesContainer;


class DashboardServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind('app.dashboard.modules', fn() => new ModulesContainer());
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $router = $this->app['router'];
        $router->aliasMiddleware('admin', AdminMiddleware::class);
        $router->aliasMiddleware('devAdmin', DevAdminMiddleware::class);
        $router->aliasMiddleware('module', ModuleCheckActive::class);

        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeModuleCommand::class
            ]);
        }

        $this->mergeConfigFrom(
            __DIR__ . '/../../config/dashboard.php', 'dashboard'
        );

        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        Blade::componentNamespace('Kontur\\Dashboard\\App\\View\\Components', 'dashboard');
        //$this->loadViewsFrom(__DIR__ . '/../../resources/views', 'dashboard');
        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');

        $this->publishes([
            __DIR__ . '/../../config/dashboard.php' => config_path('dashboard.php'),
            //__DIR__ . '/../../resources/views' => resource_path('views/vendor/admin'),
        ]);

        Blade::if('module', function ($module) {
            if (Modules::get($module)->isActive()) {
                return true;
            }
            return false;
        });

        Collection::macro('addItems', function (array $items) {
            foreach ($items as $item) {
                $this->add($item);
            }
        });

        Collection::macro('getDataList', function ($keyAttr, $valueAttr) {
            foreach ($this as $item) {
                $data[] = [
                    'key' => $item->$keyAttr,
                    'value' => $item->$valueAttr,
                ];
            }
            return $data ?? [];
        });
    }
}
