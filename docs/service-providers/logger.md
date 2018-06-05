# Logger

This service provider can provider `Monolog` logging service in the application

## Installation

1. Open the default application config file named `app.php`

        vim config/app.php

2. Add/Enable the following line

        'providers' => [
            ...
            Slimork\Providers\Log\LogServiceProvider::class,
            ...
        ]

3. Edit the default logger config like store log path, level and so on

        vim config/logger.php

    - default store log path: `/storage/logs`

## Usage

You can access the logger service provider by the following code

    $this->log->debug('message');
    $this->log->info('message');
    $this->log->notice('message');
    $this->log->warn('message');
    $this->log->warning('message');
    $this->log->error('message');
    $this->log->critical('message');
    $this->log->alert('message');
    $this->log->emergency('message');

## Processors

This logger service provider was enabled uid processor by default.

If you want to add or disable processor, please change the processor section in the logger config (`config/logger.php`) like

    'processors' => [
        Monolog\Processor\UidProcessor::class,
        ...
        Your\Custom\Or\Monolog\Processor::class,
        ...
    ],

## Handlers

This logger service provider was enabled rotating file handler by default.

If you want to add or disable processor, please change the handler section in the logger config (`config/logger.php`) like

    'handlers' => [
        'rotate' => [
            'handler' => Slimork\Providers\Log\Handlers\RotatingFileHandler::class,
            'options' => [
                'max_file' => 5
            ]
        ],
        ...
        'IDENTITY_NAME' => [
            'handler' => Your\Custom\Or\Monolog\Handler::class,
            'option'  => [
                'HANDLER_OPTION_KEY' = 'HANDLER_OPTION_VALUE'
            ]
        ],
        ...
    ],

