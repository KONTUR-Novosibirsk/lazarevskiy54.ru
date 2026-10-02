<?php

namespace Modules\Services\App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Kontur\Dashboard\App\Facades\Modules;
use Kontur\Dashboard\App\Modules\Menu\MenuItem;
use Kontur\Dashboard\App\Modules\Module;
use Modules\Menu\App\Facades\MenuBuilder;
use Modules\Menu\App\Models\MenuItem as MenuItemModel;
use Modules\Services\App\Menu\NestedService;

final class ServicesServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $modulePath = dirname(__DIR__, 2);
        $moduleName = settings('name', 'services', 'Услуги');
        $resourcePath = resource_path('views/services');

        $this->loadViewsFrom($resourcePath, 'services');
        $this->loadRoutesFrom($modulePath . '/routes/admin.php');
        $this->loadRoutesFrom($modulePath . '/routes/public.php');
        $this->loadMigrationsFrom($modulePath . '/database/migrations');

        Blade::componentNamespace('Modules\\Services\\App\\Http\\Public\\Components', 'services');

        $module = new Module(
            id: 'services',
            name: $moduleName,
            sidebarItems: [
                new MenuItem(
                    name: $moduleName,
                    routeName: 'admin.services.index',
                    icon: '<i class="bi bi-cash-coin"></i>',
                )
            ],
        );

        Modules::register($module);

        if($module->isActive()) {
            $menuItem = new MenuItemModel([
                'name'       => $moduleName,
                'route_name' => 'services.index',
                'branch_class' => NestedService::class,
            ]);

            MenuBuilder::add([$menuItem], 'Модули');
        }
    }
}
