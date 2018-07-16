<?php
namespace Slimork\Providers\Pagination\Paginator;

use Illuminate\Pagination\Paginator as BasePaginator;
use Slimork\Providers\Pagination\Traits\PaginatorOffset;

class SimplePaginator extends BasePaginator {

    use PaginatorOffset;

}
