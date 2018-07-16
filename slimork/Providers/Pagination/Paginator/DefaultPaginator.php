<?php
namespace Slimork\Providers\Pagination\Paginator;

use Illuminate\Pagination\LengthAwarePaginator;
use Slimork\Providers\Pagination\Traits\PaginatorOffset;

class DefaultPaginator extends LengthAwarePaginator {

    use PaginatorOffset;

}
