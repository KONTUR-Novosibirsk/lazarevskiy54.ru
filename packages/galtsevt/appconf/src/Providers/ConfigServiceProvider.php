<?php

namespace Galtsevt\AppConf\Providers;

use DirectoryIterator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class ConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->mergeConfigFrom(
            __DIR__ . '/../config/admin_settings.php', 'admin_settings'
        );

        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        $this->publishes([
            __DIR__ . '/../config/admin_settings.php' => config_path('admin_settings.php'),
        ]);

        $this->publishes([
            __DIR__ . '/../app/settings' => app_path('settings'),
        ], 'appConfSettingsPath');
    }
}
