<?php

return [
    'name' => 'Контакты',
    'sort' => 2,
    'data' => [
        'email' => [
            'name' => 'E-mail администратора',
            'placeholder' => 'E-mail администратора',
            'rules' => 'email|nullable',
        ],
        'emailPublic' => [
            'name' => 'E-mail на сайте',
            'placeholder' => 'E-mail на сайте',
            'rules' => 'email|nullable',
        ],
        'phone' => [
            'name' => 'Телефон',
            'placeholder' => 'Телефон',
            'rules' => 'string|max:18|regex:/^([0-9\s\-\+\(\)]*)$/|nullable',
        ],
        'phone2' => [
            'name' => 'Дополнительный телефон',
            'placeholder' => 'Дополнительный телефон',
            'rules' => 'string|max:18|regex:/^([0-9\s\-\+\(\)]*)$/|nullable',
        ],
        'address' => [
            'name' => 'Адрес компании',
            'type' => 'textarea',
            'placeholder' => 'Адрес компании',
            'rules' => 'string|max:500|nullable',
        ],

    ]
];
