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

**Create default paginator**

    $paginator = $this->paginator->items('[items]')->total(5)->perPage(1)->currentPage(1)->default();

**Directly create simple pagiantor**

    $paginator = $this->paginator->createSimplePaginator('[items]', 'per_page', 'current_page');

**Directly create default pagiantor**

    $paginator = $this->paginator->createDefaultPaginator('[items]', 'total_item', 'per_page', 'current_page');

**Render the pagination**

    echo $pagination->render();

**Render the pagination with custom view**

    echo $pagination->render('custom_view.html');

**Render the pagination with custom view and data**

    echo $pagination->render('custom_view.html', [
        'name' => 'value'
    ]);

More details or methods, please reference to [API Documentation](https://laravel.com/api/5.6/Illuminate/Pagination/Paginator.html)
