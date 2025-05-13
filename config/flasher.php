<?php // config/flasher.php

return [
    'plugins' => [
        'notyf' => [
            'scripts' => [
                '/vendor/flasher/flasher-notyf.min.js',
            ],
            'styles' => [
                '/vendor/flasher/flasher-notyf.min.css',
            ],
            'options' => [
                // Optional: Add global options here
                'dismissible' => true,
                'duration' => 2000,
            ],
        ],
        'toastr' => [
            'scripts' => [
                '/vendor/flasher/jquery.min.js',
                '/vendor/flasher/toastr.min.js',
                '/vendor/flasher/flasher-toastr.min.js',
            ],
            'styles' => [
                '/vendor/flasher/toastr.min.css',
            ],
            'options' => [
                // Optional: Add global options here
                'closeButton' => true,
                'positionClass' => 'toast-top-center',
            ],
        ],
    ],
];
