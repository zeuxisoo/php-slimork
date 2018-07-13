# Pagination

Simple pagination service to automate generate navigation links by `Illuminate/Pagination`

## Installation

1. Open the default application config file named `app.php`

        vim config/app.php

2. Add/Enable the following line

        'providers' => [
            ...
            Slimork\Providers\Pagination\PaginationServiceProvider::class,
            ...
        ]

## Usage

This package mainly provides pagination services for database service providers. But you can also use it independently to provide pagination services.

    $paginator = new \Slimork\Providers\Pagination\Paginator('items', 'per page', 'current page');

    $paginator->render('default.simple.html', [
        'paginator' => $paginator
    ]);

More details or methods, please reference to [API Documentation](https://laravel.com/api/5.6/Illuminate/Pagination/Paginator.html)
