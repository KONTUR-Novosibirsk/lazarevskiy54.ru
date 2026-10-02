<?php

use Illuminate\Support\Facades\Auth;

return [
    'name' => 'Блок услуг',
    'visible' => function () {
        return Auth::user()->isDevAdmin();
    },
    'sort' => 10,
    'data' => [
        'component_is_active' => [
            'name' => 'Активировать',
            'type' => 'checkbox',
            'rules' => 'boolean',
            'default' => 0,
        ],
        'component_title' => [
            'name' => 'Название блока',
            'rules' => 'string|max:250',
            'default' => 'Услуги',
        ],
        'component_content' => [
            'name' => 'Контент блока',
            'type' => 'editor',
            'rules' => 'nullable|string',
            'default' => '',
        ],
        'component_template' => [
            'name' => 'Шаблон',
            'type' => 'select',
            'rules' => 'string|max:250',
            'data' => fn () => templates('views/services/components/homepage'),
            'default' => 'list',
        ],
        'component_depth' => [
            'name' => 'Глубина блока',
            'rules' => 'integer|min:1|max:20',
            'default' => 1,
        ],
        'component_per_page' => [
            'name' => 'Услуг на блоке',
            'rules' => 'integer|min:1',
            'default' => 10,
        ],
        'component_order_by' => [
            'name' => 'Сортировать по полю',
            'type' => 'select',
            'rules' => 'string|max:250',
            'data' => fn () => [
                ['key' => 'name', 'value' => 'Названия'],
                ['key' => 'created_at', 'value' => 'Дате публикации'],
                ['key' => 'price', 'value' => 'Цене'],
            ],
            'default' => 'created_at',
        ],
        'component_order_direction' => [
            'name' => 'Направление сортировки',
            'type' => 'select',
            'rules' => 'string|in:asc,desc',
            'data' => fn () => [
                ['key' => 'asc', 'value' => 'По возрастанию'],
                ['key' => 'desc', 'value' => 'По убыванию'],
            ],
            'default' => 'desc',
        ],
    ]
];
