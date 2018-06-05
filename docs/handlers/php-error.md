# NotFoundHandler

Overwrite to default runtime PHP errors

## Usage

1. Open the `config/app.php`

        vim config/app.php

2. Enable the `Slimork` php error handler

        'handlers' => [
            ...
            Slimork\Exceptions\Handlers\PhpErrorHandler::class,
            ...
        ],

## Custom layout

If you want to custom the default error handler layout, You can follow these steps

1. Open the `resources/views/errors/500.php.html`

        vim resources/views/errors/500.php.html

2. Modify the content in HTML
