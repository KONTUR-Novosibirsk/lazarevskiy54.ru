<?php

namespace Galtsevt\LaravelStorage\App\Providers;

use Illuminate\Support\ServiceProvider;

class StorageServiceProvider extends ServiceProvider
{

    public function register(): void
    {

    }

    public function boot(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/laravel-storage.php', 'laravel-storage'
        );
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        $this->publishes([
            __DIR__ . '/../../config/laravel-storage.php' => config_path('laravel-storage.php'),
        ], 'laravel-storage');
    }
}
