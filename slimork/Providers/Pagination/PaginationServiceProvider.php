<?php
namespace Slimork\Providers\Pagination;

use Slimork\Contracts\ServiceProvider;

/**
 * Usage
 * =====
 *
 * Pagination:
 *
 */
class PaginationServiceProvider extends ServiceProvider {

    public function register() {

    }

    public function boot() {
        $settings = $this->container->get('settings');
        $request  = $this->container->get('request');

        // Get current full url but without &page=xx / ?page=xx keyword
        $query_pairs = [];

        parse_str($request->getUri()->getQuery(), $query_pairs);

        if (array_key_exists('page', $query_pairs) === true) {
            unset($query_pairs['page']);
        }

        $query_string = http_build_query($query_pairs);
        $current_url  = (string) $request->getUri()->withQuery($query_string);
        $current_page = $request->getParam('page');

        // Setup paginator
        Paginator::setDefaultTemplate($settings['pagination']['views']);

        Paginator::viewFactoryResolver(function() use ($settings) {
            return new $settings['pagination']['resolver']['view']($this->container);
        });

        Paginator::currentPathResolver(function () use ($current_url) {
            return $current_url;
        });

        Paginator::currentPageResolver(function() use ($current_page) {
            return $current_page;
        });
    }

}
