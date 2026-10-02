<?php
return [
    'name' => 'callback',
    'title' => 'Обратная связь',
    'form' => [
        'name' => [
            'type' => 'input',
            'label' => 'Имя',
            'placeholder' => 'Ваше имя',
            'rules' => 'required|string|max:250',
        ],
        'email' => [
            'type' => 'input',
            'label' => 'Email',
            'placeholder' => 'Ваш email',
            'rules' => 'required|email',
        ],
        'phone' => [
            'type' => 'phone',
            'label' => 'Телефон',
            'placeholder' => 'Номер телефона',
            'rules' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:9',
        ],
        'policy' => [
            'type' => 'policy',
            'label' => 'Вы должны согласиться с политикой конфиденциальность',
            'rules' => 'accepted',
        ]
    ],
    'button' => 'Отправить',
];
