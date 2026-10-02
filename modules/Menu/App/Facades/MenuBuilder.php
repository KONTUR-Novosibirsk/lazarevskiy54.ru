<?php

namespace Modules\Menu\App\Facades;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Modules\Menu\App\Menu\MenuBuilder add(array $menuItems, string $groupName = 'main'): static
 * @method static \Modules\Menu\App\Menu\MenuBuilder getContainers(): array
 * @method static \Modules\Menu\App\Menu\MenuBuilder deleteExistItems(Collection $items): static
 *
 * @see \Modules\Menu\App\Menu\MenuBuilder
 *
 **/

class MenuBuilder extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'app.menu.builder';
    }
}
