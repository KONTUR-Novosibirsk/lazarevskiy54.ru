<?php

return [
    'name' => 'Сео',
    'sort' => 21,
    'data' => [
        'counters' => [
            'name' => 'Счетчики',
            'type' => 'textarea',
            'placeholder' => 'Счетчики',
            'rules' => 'string|max:5000|nullable',
        ]
    ],
    'rights' => 'dev'
];
