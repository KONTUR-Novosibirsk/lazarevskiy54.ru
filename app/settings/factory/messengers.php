<?php

use Illuminate\Support\Facades\Auth;

return [
    'name' => 'Мессенджеры',
    'sort' => 4,
    'data' => [
        'whatsapp' => [
            'name' => 'Whatsapp',
            'placeholder' => 'Whatsapp',
            'rules' => 'url|nullable',
        ],
        'telegram' => [
            'name' => 'Телеграм',
            'placeholder' => 'Телеграм',
            'rules' => 'url|nullable',
        ],
        'viber' => [
            'name' => 'Viber',
            'placeholder' => 'Viber',
            'rules' => 'url|nullable',
        ],
    ]
];
