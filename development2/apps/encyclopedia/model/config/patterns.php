<?php
    $regex = [
    'phone' => "/^\+380\d{3}\d{2}\d{2}\d{2}$/",
    'mail' => "/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/",
    'name' =>  "/^[a-zA-Zа-яА-Я]+$/ui",
    'position' => "/[0-9]+/"
    ];

    $callbacks = [
        'phone' => function () {
            $patterns = [];
            $patterns[0] = '/^0/';
            $patterns[1] = '/^80/';
            $patterns[2] = '/^380/';
            $replacements = '+380';
            return preg_replace($patterns, $replacements, $var);
        }

    ];
