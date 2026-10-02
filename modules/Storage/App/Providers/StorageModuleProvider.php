<?php

namespace Modules\Storage\App\Providers;

use Kontur\Dashboard\App\Modules\Menu\MenuItem;
use Kontur\Dashboard\App\Modules\Module;
use Kontur\Dashboard\App\Modules\ModuleProvider;

class StorageModuleProvider extends ModuleProvider
{

    protected string $name = 'storage';

    protected function init(): void
    {
        // app init
    }

    protected function run(): void
    {
        // after init app
    }

    protected function getModule(): Module
    {
        return new Module(
            id: 'storage',
            name: 'Файловое хранилище',
        );
    }

    protected function getDir(): string
    {
        return __DIR__;
    }

}
