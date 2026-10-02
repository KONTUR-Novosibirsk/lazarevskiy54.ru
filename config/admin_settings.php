<?php

return [
    'middleware' => ['web', 'auth', 'dashboard'],
    'extends_layout' => 'dashboard::layouts.app',
    'groups' => [
        'main' => [
            'name' => 'Основные',
            'path' => 'settings/factory',
        ],
        'news' => [
            'name' => 'Новости',
            'path' => 'settings/modules/news',
        ],
        'shop' => [
            'name' => 'Каталог',
            'path' => 'settings/modules/shop',
        ],
        'telegram' => [
            'name' => 'Уведомления в telegram',
            'path' => 'settings/modules/telegram',
        ],
        'gallery' => [
            'name' => 'Галерея',
            'path' => 'settings/modules/gallery',
        ],
        'sale' => [
            'name' => 'Акции',
            'path' => 'settings/modules/sale',
        ],
        'services' => [
            'name' => 'Услуги',
            'path' => 'settings/modules/services',
        ],
        'reviews' => [
            'name' => 'Отзывы',
            'path' => 'settings/modules/reviews',
        ]
    ]
];
