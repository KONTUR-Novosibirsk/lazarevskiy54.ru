<?php

namespace Modules\Shop\App\Providers;

use Galtsevt\LaravelSeo\App\Facades\Seo;
use Galtsevt\LaravelSeo\App\Services\Metadata\TemplateSeo;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Kontur\Dashboard\App\Facades\Modules;
use Kontur\Dashboard\App\Modules\Menu\MenuItem;
use Kontur\Dashboard\App\Modules\Module;
use Modules\Menu\App\Facades\MenuBuilder;
use Modules\Shop\App\Contracts\ProductFilterContract;
use Modules\Shop\App\Events\OrderCreated;
use Modules\Shop\App\Filters\ProductFilter;
use Modules\Shop\App\Filters\TradeOfferFilter;
use Modules\Shop\App\Listeners\SendOrderNotification;
use Modules\Shop\App\Menu\NestedCategory;
use Modules\Shop\App\Middleware\CartMiddleware;
use Modules\Shop\App\Models\ShopCategory;
use Modules\Shop\App\Models\ShopProduct;
use Modules\Shop\App\Services\ShopOrdersHeaderItem;

class ShopServiceProvider extends ServiceProvider
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

        $this->app->bind(ProductFilterContract::class, function (Application $app) {
            if (settings('with_trade_offers', 'shop', false)) {
                return $app->make(TradeOfferFilter::class);
            }
            return $app->make(ProductFilter::class);
        });

        $router = $this->app['router'];
        $router->pushMiddlewareToGroup('web', CartMiddleware::class);

        $module = new Module(
            id: 'shop',
            name: settings('name', 'shop', 'Магазин'),
            sidebarItems: [
                new MenuItem(
                    name: settings('name', 'shop', 'Магазин'),
                    routeName: 'admin.shop.index',
                    icon: '<i class="bi bi-basket-fill"></i>',
                    menuItems: [
                        new MenuItem(
                            name: 'Все товары',
                            routeName: 'admin.shop.index',
                        ),
                        new MenuItem(
                            name: 'Атрибуты',
                            routeName: 'admin.shop.attribute.index',
                        ),
                        new MenuItem(
                            name: 'Фильтры',
                            routeName: 'admin.shop.filter.index',
                        )
                    ]
                )
            ],
        );
        Modules::register($module);

        if ($module->isActive()) {
            Event::listen(
                OrderCreated::class,
                [SendOrderNotification::class, 'handle']
            );

            MenuBuilder::add([
                new \Modules\Menu\App\Models\MenuItem([
                    'name' => settings('name', 'shop', 'Каталог'),
                    'route_name' => 'shop.index',
                    'branch_class' => NestedCategory::class,
                ])
            ], 'Модули');

            Seo::template()->add(
                new TemplateSeo(
                    name: 'Магазин [Товары]',
                    model: ShopProduct::class,
                )
            )->add(
                new TemplateSeo(
                    name: 'Магазин [Категории]',
                    model: ShopCategory::class,
                )
            );
        }

        $this->mergeConfigFrom(
            __DIR__ . '/../../config/shop.php',
            'shop'
        );
        Blade::componentNamespace('Modules\\Shop\\App\\View\\Components', 'shop');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'shop');

        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');

        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        $this->publishes([
            __DIR__ . '/../../config/shop.php' => config_path('shop.php'),
            __DIR__ . '/../../resources/views' => resource_path('views/vendor/shop'),
        ], 'module-resources');
    }
}
