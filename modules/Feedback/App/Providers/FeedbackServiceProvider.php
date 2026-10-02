<?php

namespace Modules\Feedback\App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Kontur\Dashboard\App\Facades\Modules;
use Kontur\Dashboard\App\Modules\Module;
use Modules\Feedback\App\Events\FeedbackCreated;
use Modules\Feedback\App\Feedback\FeedbackConfigFactory;
use Modules\Feedback\App\Listeners\SendFeedbackNotification;
use Modules\Feedback\App\Services\NoticeRegister;
use Modules\Feedback\App\Widgets\FeedbackWidget;

class FeedbackServiceProvider extends ServiceProvider
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
        $module = new Module(
            id: 'feedback',
            name: 'Обратная связь',
            widgets: [
                new FeedbackWidget(),
            ],
        );
        Modules::register($module);

        if ($module->isActive()) {
            Event::listen(
                FeedbackCreated::class,
                [SendFeedbackNotification::class, 'handle']
            );

            $noticeRegister = new NoticeRegister;
            call_user_func($noticeRegister);
        }

        $this->mergeConfigFrom(
            __DIR__ . '/../../config/feedback.php', 'feedback'
        );
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'feedback');
        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');

        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        $this->publishes([
            __DIR__ . '/../../config/feedback.php' => config_path('feedback.php'),
            __DIR__ . '/../../resources/views' => resource_path('views/vendor/feedback'),
        ], 'module-resources');

        $this->app->singleton(FeedbackConfigFactory::class, function () {
            return new FeedbackConfigFactory();
        });
    }
}
