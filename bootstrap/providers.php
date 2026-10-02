<?php

return [
    App\Providers\AppServiceProvider::class,
    /*
    * packages
    */
    \Kontur\Dashboard\App\Providers\DashboardServiceProvider::class,
    \Galtsevt\LaravelSeo\App\Providers\SeoServiceProvider::class,
    \Galtsevt\LaravelStorage\App\Providers\StorageServiceProvider::class,
    \Modules\Storage\App\Providers\StorageModuleProvider::class,
    \Galtsevt\AppConf\Providers\ConfigServiceProvider::class,

    \Modules\News\App\Providers\NewsModuleProvider::class,
    \Modules\Gallery\App\Providers\GalleryModuleProvider::class,
    \Modules\Pages\App\Providers\PageModuleProvider::class,
    \Modules\InfoBlocks\App\Providers\InfoBlocksServiceProvider::class,
    \Modules\Shop\App\Providers\ShopServiceProvider::class,
    \Modules\Menu\App\Providers\MenuServiceProvider::class,
    \Modules\Feedback\App\Providers\FeedbackServiceProvider::class,
    \Modules\Notification\App\Providers\NotificationServiceProvider::class,
    \Modules\Widgets\App\Providers\WidgetServiceProvider::class,
    \Modules\Reviews\App\Providers\ReviewModuleProvider::class,
    \Modules\Questions\App\Providers\QuestionModuleProvider::class,
    \Modules\Slider\App\Providers\SliderModuleProvider::class,
    \Modules\Sale\App\Providers\SaleModuleProvider::class,
    \Modules\TelegramNotification\App\Providers\TelegramNotificationServiceProvider::class,
    \Modules\Services\App\Providers\ServicesServiceProvider::class,
    \Modules\Cookie\App\Providers\CookieServiceProvider::class,
    \Modules\Accounts\App\Providers\AccountsServiceProvider::class,
];
