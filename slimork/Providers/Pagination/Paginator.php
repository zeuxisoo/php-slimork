<?php
namespace Slimork\Providers\Pagination;

use Illuminate\Pagination\Paginator as BasePaginator;

class Paginator {

    public function make($items, $per_page, $current_page = null, array $options = []) {
        return new BasePaginator($items, $per_page, $current_page, $options);
    }

    public static function setDefaultTemplate($views) {
        BasePaginator::defaultView($views['default']);
        BasePaginator::defaultSimpleView($views['simple']);
    }

    public static function setDefaultResolver($viewFactory, $currentPath, $currentPage) {
        BasePaginator::viewFactoryResolver(function() use ($viewFactory) {
            return $viewFactory;
        });

        BasePaginator::currentPathResolver(function() use ($currentPath) {
            return $currentPath;
        });

        BasePaginator::currentPageResolver(function() use ($currentPage) {
            return $currentPage;
        });
    }

}
