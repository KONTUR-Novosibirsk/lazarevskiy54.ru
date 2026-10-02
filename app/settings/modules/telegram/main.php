<?php

return [
    'name' => 'Основные',
    'data' => [
        'token' => [
            'name' => 'Токен бота',
            'placeholder' => 'Токен бота',
            'rules' => 'string|max:250',
        ],
        'active' => [
            'name' => 'Отправлять уведомления в телеграм',
            'type' => 'checkbox',
            'rules' => 'boolean',
        ],
    ]
];
