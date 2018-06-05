# ErrorHandler

Overwrite default `Slim` framework application's error handler

## Usage

1. Open the `config/app.php`

        vim config/app.php

2. Enable the `Slimork` error handler

        'handlers' => [
            ...
            Slimork\Exceptions\Handlers\ErrorHandler::class,
            ...
        ],

## Custom layout

If you want to custom the default error handler layout, You can follow these steps

1. Open the `resources/views/errors/500.html`

        vim resources/views/errors/500.html

2. Modify the content in HTML
