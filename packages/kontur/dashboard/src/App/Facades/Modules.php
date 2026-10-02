<?php

namespace Kontur\Dashboard\App\Facades;

use Illuminate\Support\Facades\Facade;
use Kontur\Dashboard\App\Modules\AbstractModule;

/**
 * @method static AbstractModule register(AbstractModule $module)
 * @method static array getAllModules()
 * @method static array getActiveModules()
 * @method static array getSidebarItems()
 * @method static array getHeaderItems()
 * @method static array getWidgets(bool $active = false)
 * @method static AbstractModule get(string $name)
 * @method static array getConfig(string $module, mixed $default)
 *
 * @see \Kontur\Dashboard\App\Modules\ModulesContainer
 *
 **/

class Modules extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'app.dashboard.modules';
    }
}
