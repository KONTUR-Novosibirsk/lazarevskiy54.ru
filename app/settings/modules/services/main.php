<?php

return [
    'name' => 'Основные',
    'visible' => function () {
        return Auth::user()->isDevAdmin();
    },
    'sort' => 0,
    'data' => [
        'name' => [
            'name' => 'Название модуля',
            'rules' => 'string|max:250',
            'default' => 'Услуги',
        ],
        'content' => [
            'name' => 'Контент модуля',
            'type' => 'editor',
            'rules' => 'nullable|string',
            'default' => '',
        ],
        'index_template' => [
            'name' => 'Шаблон главной',
            'type' => 'select',
            'rules' => 'string|max:250',
            'data' => fn () => templates('views/services/pages/index'),
            'default' => 'list',
        ],
        'show_template' => [
            'name' => 'Шаблон карточки',
            'type' => 'select',
            'rules' => 'string|max:250',
            'data' => fn () => templates('views/services/pages/show'),
            'default' => 'minimal',
        ],
        'per_page' => [
            'name' => 'Услуг на странице',
            'rules' => 'integer|min:1',
            'default' => 10,
        ],
        'order_by' => [
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
        'order_direction' => [
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

