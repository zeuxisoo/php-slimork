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
 *      $paginator->render('default.simple.html', [
 *          'paginator' => $paginator
 *      ]);
 *
 *  Create default paginator
 *
 *      $paginator = $this->paginator->items('[items]')->total(5)->perPage(1)->currentPage(1)->default();
 *
 *      $paginator->render('default.html', [
 *          'paginator' => $paginator
 *      ]);
 *
 *  Directly create simple paginaor
 *
 *      $paginator = $this->paginator->createSimplePaginator('[items]', 'per_page', 'current_page');
 *
 *      $paginator->render('default.simple.html', [
 *          'paginator' => $paginator
 *      ]);
 *
 *  Directly create default paginaor
 *
 *      $paginator = $this->paginator->createDefaultPaginator('[items]', 'total_items', 'per_page', 'current_page');
 *
 *      $paginator->render('default.html', [
 *          'paginator' => $paginator
 *      ]);
 *
 *  Other methods like:
 *
 *      $paginator->nextPageUrl();
 */
class PaginationServiceProvider extends ServiceProvider {

    public function register() {
        $this->container->set('paginator', function($container) {
            return new Paginator();
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
        Paginator::setDefaultTemplate($settings['pagination']['views']);
        Paginator::setDefaultResolver(
            new $settings['pagination']['paginator']($this->container),
            $current_url,
            $current_page
        );
    }

}
