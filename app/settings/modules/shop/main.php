<?php

use Modules\Shop\App\Models\ShopProduct;

return [
    'name' => 'Основные',
    'data' => [
        'name' => [
            'name' => 'Название каталога',
            'placeholder' => 'Название каталога',
            'rules' => 'string|max:250',
        ],
        'currency' => [
            'name' => 'Валюта',
            'type' => 'select',
            'data' => function () {
                return [
                    [
                        'key' => '&#8381',
                        'value' => 'Рубль',
                    ],
                ];
            },
            'rules' => 'string|max:50',
        ],
        'with_trade_offers' => [
            'name' => 'Включить торговые предложения',
            'type' => 'checkbox',
            'rules' => 'boolean|nullable',
        ],
        'image' => [
            'name' => 'Изображение',
            'type' => 'image',
            'rules' => 'nullable',
            'model' => ShopProduct::class,
            'prefix' => 'shopImage'
        ]
    ]
];
