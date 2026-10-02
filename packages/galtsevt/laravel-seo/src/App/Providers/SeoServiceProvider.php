<?php
namespace Galtsevt\LaravelSeo\App\Providers;

use Galtsevt\LaravelSeo\App\Middleware\SeoForUrlMiddleware;
use Galtsevt\LaravelSeo\App\Services\SeoTools;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Kontur\Dashboard\App\Facades\Modules;
use Kontur\Dashboard\App\Modules\Menu\MenuItem;
use Kontur\Dashboard\App\Modules\Module;

class SeoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('app.seo.tools', fn() => new SeoTools());
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $router = $this->app['router'];
        $router->pushMiddlewareToGroup('web', SeoForUrlMiddleware::class);

        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        Blade::componentNamespace('Galtsevt\\LaravelSeo\\App\\View\\Components', 'laravel-seo');
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'laravel-seo');

        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');

        Modules::register(new Module(
            id: 'seo',
            name: 'Kontur SEO',
            sidebarItems: [
                new MenuItem(
                    name: 'Kontur SEO',
                    routeName: 'admin.seo.index',
                    icon: '<i class="bi bi-life-preserver"></i>',
                )
            ],
        ));
    }
}
