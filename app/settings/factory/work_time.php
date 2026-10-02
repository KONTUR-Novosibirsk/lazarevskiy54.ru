<?php

use Illuminate\Support\Facades\Auth;

return [
    'name' => 'Рабочее время',
    'sort' => 5,
    'data' => [
        'monday' => [
            'name' => 'Понедельник-суббота',
            'placeholder' => 'Понедельник-суббота',
            'rules' => 'string|max:250|nullable',
        ],
        'sunday' => [
            'name' => 'Воскресенье',
            'placeholder' => 'Воскресенье',
            'rules' => 'string|max:250|nullable',
        ],
    ]
];
