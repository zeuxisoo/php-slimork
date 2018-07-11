<?php
namespace Slimork\Providers\Pagination;

use Illuminate\Pagination\Paginator as BasePaginator;

class Paginator extends BasePaginator {

    public static function setDefaultTemplate($views) {
        static::defaultView($views['default']);
        static::defaultSimpleView($views['simple']);
    }

}
