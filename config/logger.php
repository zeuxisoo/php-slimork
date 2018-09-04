<?php
return [
    'path' => storage_path('/logs'),

    'level' => Slimork\Providers\Log\Logger::DEBUG,

    'processors' => [
        Monolog\Processor\UidProcessor::class
    ],

    'handlers' => [
        'rotate' => [
            'handler' => Slimork\Providers\Log\Handlers\RotatingFileHandler::class,
            'options' => [
                'max_file' => env('LOGGER_ROTATE_MAX_FILE', 5)
            ]
        ]
    ],
];
