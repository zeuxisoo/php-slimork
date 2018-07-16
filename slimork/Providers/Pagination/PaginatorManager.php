<?php
namespace Slimork\Providers\Pagination;

use Illuminate\Pagination\Paginator as BasePaginator;

class PaginatorManager {

    protected $items;
    protected $per_page;
    protected $current_page = null;
    protected $options      = [];
    protected $total;

    public function items($items) {
        $this->items = $items;

        return $this;
    }

    public function perPage($per_page) {
        $this->per_page = $per_page;

        return $this;
    }

    public function currentPage($current_page) {
        $this->current_page = $current_page;

        return $this;
    }

    public function options($options) {
        $this->options = $options;

        return $this;
    }

    public function total($total) {
        $this->total = $total;

        return $this;
    }

    // Create default or simple pagiantor
    public function default() {
        return $this->createDefaultPaginator($this->items, $this->total, $this->per_page, $this->current_page, $this->options);
    }

    public function simple() {
        return $this->createSimplePaginator($this->items, $this->per_page, $this->current_page, $this->options);
    }

    // Initial default or simple paginator
    public function createDefaultPaginator($items, $total, $per_page, $current_page = null, array $options = []) {
        return new Paginator\LengthAwarePaginator($items, $total, $per_page, $current_page, array_merge([
            'path' => BasePaginator::resolveCurrentPath(),
        ], $options));
    }

    public function createSimplePaginator($items, $per_page, $current_page = null, array $options = []) {
        return new Paginator\SimplePaginator($items, $per_page, $current_page, array_merge([
            'path' => BasePaginator::resolveCurrentPath(),
        ], $options));
    }

    // Initial parent paginator default views and resolver
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
