<?php
return [
    'views' => [
        'default' => env('PAGINATION_VIEWS_DEFAULT', 'default.html'),
        'simple'  => env('PAGINATION_VIEWS_SIMPLE', 'default.simple.html')
    ],

    'paginator' => Slimork\Providers\Pagination\DefaultPaginatorView::class,
];
