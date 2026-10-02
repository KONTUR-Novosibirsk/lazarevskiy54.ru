<?php

namespace Modules\Accounts\App\Providers;

use Illuminate\Support\Facades\Blade;
use Inertia\ServiceProvider;
use Kontur\Dashboard\App\Facades\Modules;
use Kontur\Dashboard\App\Modules\Menu\MenuItem;
use Kontur\Dashboard\App\Modules\Module;
use Modules\Menu\App\Facades\MenuBuilder;

class AccountsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $module = new Module(
            id: 'accounts',
            name: settings('name', 'accounts', 'Управление аккаунтами'),
            sidebarItems: [
                new MenuItem(
                    name: settings('name', 'accounts', 'Управление аккаунтами'),
                    routeName: 'admin.accounts.index',
                    icon: '<i class="bi bi-cash-coin"></i>',
                )
            ],
        );

        Modules::register($module);

        if($module->isActive()) {
            MenuBuilder::add([
                new \Modules\Menu\App\Models\MenuItem([
                    'name' => settings('name', 'accounts', 'Управление аккаунтами'),
                    'route_name' => 'account.index',
                ])
            ], 'Модули');
        }

        Blade::componentNamespace('Modules\\Accounts\\App\\View\\Components', 'accounts');

//        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'accounts');
        $this->loadViewsFrom(resource_path('views/vendor/accounts'), 'accounts');
        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
    }
}
