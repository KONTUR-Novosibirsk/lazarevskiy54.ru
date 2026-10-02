<?php

use Illuminate\Support\Facades\Auth;

return [
    'name' => 'Google Recaptcha',
    'sort' => 7,
    'data' => [
        'recaptcha_status' => [
            'name' => 'Включить google recaptcha v3',
            'type' => 'checkbox',
            'rules' => 'boolean',
        ],
        'recaptcha_key' => [
            'name' => 'Ключ сайта',
            'placeholder' => 'Ключ сайта',
            'rules' => 'required_if:recaptcha_status,true|max:250',
        ],
        'recaptcha_secret_key' => [
            'name' => 'Секретный ключ',
            'placeholder' => 'Секретный ключ',
            'rules' => 'required_if:recaptcha_status,true|max:250',
        ],
    ]
];
