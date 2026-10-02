<?php

use Illuminate\Support\Facades\Auth;

return [
    'name' => 'Основные',
    'data' => [
        'name' => [
            'name' => 'Название модуля',
            'placeholder' => 'Название модуля',
            'rules' => 'string|max:250',
        ],
    ]
];
