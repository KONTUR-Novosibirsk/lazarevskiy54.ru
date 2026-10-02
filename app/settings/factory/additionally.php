<?php

use Illuminate\Support\Facades\Auth;

return [
    'name' => 'Дополнительно',
    'sort' => 20,
    'data' => [
        'per_page_admin' => [
            'name' => 'Пунктов на страницу(админ панель)',
            'type' => 'select',
            'rules' => 'integer|max:100',
            'data' => function () {
                for ($perPage = 5; $perPage <= 50; $perPage = $perPage + 5) {
                    $pages[] = [
                        'key' => $perPage,
                        'value' => $perPage,
                    ];
                }
                return $pages;
            },
            'default' => 10,
        ],
        'per_page' => [
            'name' => 'Пунктов на страницу',
            'type' => 'select',
            'rules' => 'integer|max:100',
            'data' => function () {
                for ($perPage = 5; $perPage <= 50; $perPage = $perPage + 5) {
                    $pages[] = [
                        'key' => $perPage,
                        'value' => $perPage,
                    ];
                }
                return $pages;
            },
            'default' => 10,
        ],
    ]
];
