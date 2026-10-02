<?php

use Illuminate\Support\Facades\Auth;

return [
    'name' => 'Социальные сети',
    'sort' => 3,
    'data' => [
        'vk' => [
            'name' => 'Вконтакте',
            'placeholder' => 'Вконтакте',
            'rules' => 'url|nullable',
        ],
        'ok' => [
            'name' => 'Одноклассники',
            'placeholder' => 'Одноклассники',
            'rules' => 'url|nullable',
        ],
        'facebook' => [
            'name' => 'Facebook',
            'placeholder' => 'Facebook',
            'rules' => 'url|nullable',
        ],
        'instagram' => [
            'name' => 'Instagram',
            'placeholder' => 'Instagram',
            'rules' => 'url|nullable',
        ],
    ]
];
