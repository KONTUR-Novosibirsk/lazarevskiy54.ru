<?php

use Illuminate\Support\Facades\Auth;

return [
    'name' => 'Основные',
    'visible' => function () {
        return Auth::user()->isDevAdmin();
    },
    'data' => [
        'name' => [
            'name' => 'Название модуля',
            'placeholder' => 'Название модуля',
            'rules' => 'string|max:250',
        ],
    ]
];
