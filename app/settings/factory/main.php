<?php

use Illuminate\Support\Facades\Auth;

return [
    'name' => 'Основные',
    'sort' => 1,
    'data' => [
        'site_name' => [
            'name' => 'Название сайта',
            'placeholder' => 'Название сайта',
            'rules' => 'string|max:250',
        ],
        'company_name' => [
            'name' => 'Название организации',
            'placeholder' => 'Название организации',
            'rules' => 'string|max:250|nullable',
        ],
        'copyright' => [
            'name' => 'Копирайт',
            'placeholder' => 'Копирайт',
            'rules' => 'string|max:250|nullable',
        ],
        'timezone' => [
            'name' => 'Часовой пояс',
            'type' => 'select',
            'rules' => 'nullable|string|max:250',
            'data' => function () {
                return [
                    [
                        'key' => 'Asia/Novosibirsk',
                        'value' => 'Asia/Novosibirsk (UTC +7)',
                    ],
                    [
                        'key' => 'Asia/Almaty',
                        'value' => 'Asia/Almaty (UTC +6)',
                    ],
                    [
                        'key' => 'Europe/Moscow',
                        'value' => 'Europe/Moscow (UTC +3)',
                    ],
                ];
            }
        ],
        'policy_page' => [
            'name' => 'Политика конфиденциальности',
            'type' => 'select',
            'rules' => 'nullable',
            'data' => function () {
                $pages = \Modules\Pages\App\Models\Page::query()->get();
                foreach ($pages as $page) {
                    $data[] = [
                        'key' => $page->alias,
                        'value' => $page->title,
                    ];
                }
                return $data ?? [];
            }
        ],
        'slogan' => [
            'name' => 'Слоган сайта',
            'type' => 'editor',
            'placeholder' => 'Слоган сайта',
            'rules' => 'string|max:500|nullable',
        ],

    ]
];
