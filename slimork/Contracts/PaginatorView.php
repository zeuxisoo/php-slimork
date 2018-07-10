<?php
namespace Slimork\Contracts;

interface PaginatorView {

    public function __construct($container);

    // Reference: https://github.com/laravel/framework/blob/5.6/src/Illuminate/Pagination/Paginator.php#L108
    public function make($view, $data = [], $merge_data = []);

    // Reference: https://github.com/laravel/framework/blob/5.6/src/Illuminate/Pagination/Paginator.php#L107-L111
    public function render();

}
