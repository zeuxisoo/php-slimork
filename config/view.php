<?php
return [

    'default' => [
        'charset'          => env('VIEW_CHARSET', 'utf-8'),
        'auto_reload'      => true,
        'strict_variables' => false,
        'autoescape'       => env('VIEW_AUTOESCAPE', 'html'),
    ],

    'extensions' => [
        Slimork\Providers\View\DefaultViewExtension::class
    ]

];
