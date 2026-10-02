<?php

namespace Modules\Notification\App\Providers;

use Illuminate\Support\ServiceProvider;
use Kontur\Dashboard\App\Facades\Modules;
use Kontur\Dashboard\App\Modules\Menu\MenuItem;
use Kontur\Dashboard\App\Modules\Module;
use Modules\Notification\App\Services\NoticeContainer;

class NotificationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind('app.notification.notice', fn() => new NoticeContainer());
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $module = new Module(
            id: 'notification',
            name: 'Уведомления',
            sidebarItems: [
            ],
        );
        Modules::register($module);
    }
}
