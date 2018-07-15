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

This package mainly provides pagination services for database service providers.

But you can also use it independently to provide pagination services.

Firstly, You need to create the paginator object first by pass the `items`, `per page item` and `current page number` like

    $paginator = $this->paginator->make([1,2,3,4,5], 1, 3);

Now, render the paginatior template with related paginator object

    $paginator->render('default.simple.html', [
        'paginator' => $paginator
    ]);

More details or methods, please reference to [API Documentation](https://laravel.com/api/5.6/Illuminate/Pagination/Paginator.html)
