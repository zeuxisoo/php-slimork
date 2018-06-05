# NotAllowedHandler

Overwrite to default `Slim` framework application's not allowed exception

## Usage

1. Open the `config/app.php`

        vim config/app.php

2. Enable the `Slimork` not allowered handler

        'handlers' => [
            ...
            Slimork\Exceptions\Handlers\NotAllowedHandler::class,
            ...
        ],

## Custom layout

If you want to custom the default error handler layout, You can follow these steps

1. Open the `resources/views/errors/405.html`

        vim resources/views/errors/405.html

2. Modify the content in HTML
