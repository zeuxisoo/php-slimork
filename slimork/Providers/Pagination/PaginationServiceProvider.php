<?php
namespace Slimork\Providers\Pagination;

use Slimork\Contracts\ServiceProvider;

/**
 * Usage
 * =====
 *
 * Pagination:
 *
 *  Create simple paginator
 *
 *      $paginator = $this->paginator->items('[items]')->perPage(1)->currentPage(1)->simple();
 *
 *      $paginator->render();
 *
 *  Create default paginator
 *
 *      $paginator = $this->paginator->items('[items]')->total(5)->perPage(1)->currentPage(1)->default();
 *
 *      $paginator->render();
 *
 *  Directly create simple paginaor
 *
 *      $paginator = $this->paginator->createSimplePaginator('[items]', 'per_page', 'current_page');
 *
 *      $paginator->render();
 *
 *  Directly create default paginaor
 *
 *      $paginator = $this->paginator->createDefaultPaginator('[items]', 'total_items', 'per_page', 'current_page');
 *
 *      $paginator->render();
 *
 *  Other methods like:
 *
 *      $paginator->render('custom_view.html', '[data]');
 *      $paginator->nextPageUrl();
 */
class PaginationServiceProvider extends ServiceProvider {

    public function register() {
        $this->container->set('paginator', function($container) {
            return new PaginatorManager();
        });
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
        PaginatorManager::setDefaultTemplate($settings['pagination']['views']);
        PaginatorManager::setDefaultResolver(
            new $settings['pagination']['paginator']($this->container),
            $current_url,
            $current_page
        );
    }

}
