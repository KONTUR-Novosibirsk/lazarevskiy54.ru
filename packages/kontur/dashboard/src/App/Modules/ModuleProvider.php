<?php

namespace Kontur\Dashboard\App\Modules;

use Kontur\Dashboard\App\Facades\Modules;
use Symfony\Component\Finder\Exception\DirectoryNotFoundException;

abstract class ModuleProvider extends \Illuminate\Support\ServiceProvider
{
    protected string $name;
    protected Module $module;

    abstract protected function init(): void;

    abstract protected function run(): void;

    abstract protected function getModule(): Module;

    abstract protected function getDir(): string;

    protected function registerResources(): void
    {
        $this->loadMigrationsFrom($this->getDir() . '/../../database/migrations');
        if(is_dir($directory = $this->getDir() . '/../../resources/views'))
            $this->loadViewsFrom($directory, $this->name);
        $this->loadRoutesFrom($this->getDir() . '/../../routes/web.php');
        $this->publishes([
            $this->getDir() . '/../../resources/views' => resource_path('views/vendor/' . $this->name),
        ], 'module-resources');
    }

    public function register(): void
    {
        $this->init();
    }

    public function boot(): void
    {
        $this->module = $this->getModule();
        Modules::register($this->module);
        $this->registerResources();
        $this->run();
    }

    protected function isDashboard(): bool
    {
        return str_contains(url()->current(), '/admin');
    }
}
