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

**Create simple paginator**

    $paginator = $this->paginator->items('[items]')->perPage(1)->currentPage(1)->simple();

    $paginator->render('default.simple.html', [
        'paginator' => $paginator
    ]);

**Create default paginator**

    $paginator = $this->paginator->items('[items]')->total(5)->perPage(1)->currentPage(1)->default();

    $paginator->render('default.html', [
        'paginator' => $paginator
    ]);

**Directly create simple pagiantor**

    $paginator = $this->paginator->createSimplePaginator('[items]', 'per_page', 'current_page');

    $paginator->render('default.simple.html', [
        'paginator' => $paginator
    ]);

**Directly create default pagiantor**

    $paginator = $this->paginator->createDefaultPaginator('[items]', 'total_item', 'per_page', 'current_page');

    $paginator->render('default.html', [
        'paginator' => $paginator
    ]);

More details or methods, please reference to [API Documentation](https://laravel.com/api/5.6/Illuminate/Pagination/Paginator.html)
