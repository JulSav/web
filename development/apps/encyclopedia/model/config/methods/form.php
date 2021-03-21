<?php
$methods = [
    'submitAmbassador' => [
        'params' => [
            [
                'name' => 'firstname',
                'source' => 'p',
                'pattern' => "/^[a-zA-Zа-яА-Я]+$/ui",
                'required' => true
            ],
            [
                'name' => 'secondname',
                'source' => 'p',
                'pattern' => "/^[a-zA-Zа-яА-Я]+$/ui",
                'required' => true
            ],
            [
                'name' => 'mail',
                'source' => 'p',
                'pattern' => "/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/",
                'required' => false
            ],
            [
                'name' => 'position',
                'source' => 'p',
                'pattern' => '',
                'required' => false
            ],
            
            [
                'name' => 'phone',
                'source' => 'p',
                'pattern' => '',
                'required' => true
            ],
            
        ]
    ]
];
