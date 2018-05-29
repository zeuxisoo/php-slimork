<?php
return [

    'default' => [
        'charset'          => 'utf-8',
        'auto_reload'      => true,
        'strict_variables' => false,
        'autoescape'       => 'html',
    ],

    'extensions' => [
        Slimork\Providers\View\DefaultViewExtension::class
    ]

];
