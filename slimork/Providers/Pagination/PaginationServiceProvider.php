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
 *  Other methods like
 *
 *      $paginator->render('custom_view.html', '[data]');
 *      $paginator->nextPageUrl();
 *
 *  Full example
 *
 *      // Define the pagination related variables
 *      $per_page     = 1;
 *      $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
 *
 *      // Find the offset by pagination variables
 *      $offset = $this->paginator->findOffset($per_page, $current_page);
 *
 *      // Get total records of the admin table
 *      $total = $this->db->table('admins')->count();
 *
 *      // Get the admin records within range
 *      // - generate the default paginator
 *      // - generate the simple paginator
 *      $page_default_admins          = $this->db->table('admins')->skip($offset)->take($per_page)->get();
 *      $page_default_paginate_admins = $this->paginator->items($page_default_admins)->total($total)->perPage($per_page)->currentPage($current_page)->default();
 *
 *      $page_simple_admins          = $this->db->table('admins')->skip($offset)->take($per_page + 1)->get();
 *      $page_simple_paginate_admins = $this->paginator->items($page_simple_admins)->perPage($per_page)->currentPage($current_page)->simple();
 *
 *      // But you can simplify the above code like this, it will automatically calculate the range value
 *      $page_default_admins    = $this->db->table('admins');
 *      $page_default_paginator = $this->paginator->items($page_default_admins)->total($total)->perPage($per_page)->currentPage($current_page)->default();
 *
 *      $page_simple_admins    = $this->db->table('admins');
 *      $page_simple_paginator = $this->paginator->items($page_simple_admins)->perPage($per_page)->currentPage($current_page)->simple();
 *
 *      // Finally, you can reading records with loop and render the paginator
 *      foreach($page_default_paginator as $admin) {
 *          print_r($admin);
 *      }
 *
 *      echo $page_default_paginator->render();
 *
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
