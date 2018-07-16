<?php
namespace Slimork\Providers\Pagination\Paginator;

use Illuminate\Pagination\LengthAwarePaginator;
use Slimork\Providers\Pagination\Traits\PaginatorOffset;

class SimplePaginator extends LengthAwarePaginator {

    use PaginatorOffset;

}
