<?php
return [
    'views' => [
        'default' => 'default.html',
        'simple'  => 'default.simple.html'
    ],

    'resolver' => [
        'view' => Slimork\Providers\Pagination\DefaultPaginatorView::class,
    ],
];
