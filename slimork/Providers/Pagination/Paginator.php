<?php
namespace Slimork\Providers\Pagination;

use Illuminate\Pagination\Paginator as BasePaginator;

class Paginator extends BasePaginator {

    public static function setDefaultTemplate($views) {
        static::defaultView($views['default']);
        static::defaultSimpleView($views['simple']);
    }

    public static function setDefaultResolver($viewFactory, $currentPath, $currentPage) {
        static::viewFactoryResolver(function() use ($viewFactory) {
            return $viewFactory;
        });

        static::currentPathResolver(function() use ($currentPath) {
            return $currentPath;
        });

        static::currentPageResolver(function() use ($currentPage) {
            return $currentPage;
        });
    }

}
