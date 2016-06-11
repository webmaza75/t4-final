<?php

return [
    'db' => [
        'default' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'user' => 'root',
            'password' => '',
            'dbname' => 't4final',
        ],
    ],
    'extensions' =>
        [
            'jquery' => ['location' => 'local'],
            'bootstrap' =>
                [
                    'theme' => 'cerulean',
                ],
        ],
    'errors' => [
        404 => '//Errors/404',
        403 => '//Errors/403'
    ]
];