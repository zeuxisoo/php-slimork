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

## Example

```php
// Define the pagination related variables
$per_page     = 1;
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

// Find the offset by pagination variables
$offset = $this->paginator->findOffset($per_page, $current_page);

// Get total records of the admin table
$total = $this->db->table('admins')->count();

// Get the admin records within range
// - generate the default paginator
// - generate the simple paginator
$page_default_admins          = $this->db->table('admins')->skip($offset)->take($per_page)->get();
$page_default_paginate_admins = $this->paginator->items($page_default_admins)->total($total)->perPage($per_page)->currentPage($current_page)->default();

$page_simple_admins          = $this->db->table('admins')->skip($offset)->take($per_page + 1)->get();
$page_simple_paginate_admins = $this->paginator->items($page_simple_admins)->perPage($per_page)->currentPage($current_page)->simple();

// But you can simplify the above code like this, it will automatically calculate the range value
$page_default_admins    = $this->db->table('admins');
$page_default_paginator = $this->paginator->items($page_default_admins)->total($total)->perPage($per_page)->currentPage($current_page)->default();

$page_simple_admins    = $this->db->table('admins');
$page_simple_paginator = $this->paginator->items($page_simple_admins)->perPage($per_page)->currentPage($current_page)->simple();

// Finally, you can reading records within loop and render the paginator
foreach($page_default_paginator as $admin) {
    print_r($admin);
}

echo $page_default_paginator->render();
```

More details or methods, please reference to [`Illuminate/Pagination`](https://laravel.com/api/5.6/Illuminate/Pagination/Paginator.html)
