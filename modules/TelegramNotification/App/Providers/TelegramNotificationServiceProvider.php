<?php

namespace Modules\TelegramNotification\App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Kontur\Dashboard\App\Facades\Modules;
use Kontur\Dashboard\App\Modules\Menu\MenuItem;
use Kontur\Dashboard\App\Modules\Module;
use Modules\Feedback\App\Events\FeedbackCreated;
use Modules\Shop\App\Events\OrderCreated;
use Modules\TelegramNotification\App\Listeners\SendFeedbackNotification;
use Modules\TelegramNotification\App\Listeners\SendOrderNotification;


class TelegramNotificationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'telegram-notification');

        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
        $module = new Module(
            id: 'telegram-notification',
            name: 'Уведомления[telegram]',
            sidebarItems: [
                new MenuItem(
                    name: 'Уведомления[telegram]',
                    routeName: 'admin.tg.index',
                    icon: '<i class="bi bi-telegram"></i>',
                )
            ],
        );

        Modules::register($module);
        if ($module->isActive()) {
            Event::listen(
                FeedbackCreated::class,
                [SendFeedbackNotification::class, 'handle']
            );
            Event::listen(
                OrderCreated::class,
                [SendOrderNotification::class, 'handle']
            );
        }
    }
}
