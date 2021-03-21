<?php
$methods = [
    'submitAmbassador' => [
        'params' => [
            [
                'name' => 'firstname',
                'source' => 'p',
                'pattern' => 'name',
                'required' => true
            ],
            [
                'name' => 'secondname',
                'source' => 'p',
                'pattern' => 'name',
                'required' => true
            ],
            [
                'name' => 'mail',
                'source' => 'p',
                'pattern' => 'mail',
                'required' => false
            ],
            [
                'name' => 'position',
                'source' => 'p',
                'pattern' => 'position',
                'required' => false
            ],
            
            [
                'name' => 'phone',
                'source' => 'p',
                'pattern' => 'phone',
                'required' => true
            ],
            
        ]
    ]
];
