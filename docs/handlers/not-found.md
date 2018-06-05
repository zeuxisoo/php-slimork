# NotFoundHandler

Overwrite to default `Slim` framework application's not found exception

## Usage

1. Open the `config/app.php`

        vim config/app.php

2. Enable the `Slimork` not found handler

        'handlers' => [
            ...
            Slimork\Exceptions\Handlers\NotFoundHandler::class,
            ...
        ],

## Custom layout

If you want to custom the default error handler layout, You can follow these steps

1. Open the `resources/views/errors/404.html`

        vim resources/views/errors/404.html

2. Modify the content in HTML
