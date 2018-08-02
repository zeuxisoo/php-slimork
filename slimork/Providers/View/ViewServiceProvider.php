<?php
namespace Slimork\Providers\View;

use Slimork\Contracts\ServiceProvider;

/**
 * Usage
 * =====
 *
 * View:
 *
 *      $this->view->render('view.html', compact('variable'));
 */
class ViewServiceProvider extends ServiceProvider {

    public function register() {
        $this->container->set('view', function($container) {
            return new ViewManager($container);
        });
    }

}
