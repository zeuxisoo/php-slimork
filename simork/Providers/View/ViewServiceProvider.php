<?php
namespace Simork\Providers\View;

use Slim\Views\Twig;
use Slim\Views\TwigExtension;
use Simork\Contracts\ServiceProvider;
use Simork\Helpers\ViewHelper;

/**
 * Usage
 * =====
 *
 * View:
 *
 *      $this->view->render($response, 'view.html', compact('variable'));
 */
class ViewServiceProvider extends ServiceProvider {

    public function register() {
        $this->container['view'] = function($c) {
            $base_path = rtrim(str_ireplace('index.php', '', $c['request']->getUri()->getBasePath()), '/');

            $view = new Twig(RESOURCE_ROOT.'/view', [
                'charset'          => 'utf-8',
                'cache'            => STORAGE_ROOT.'/cache/view',
                'auto_reload'      => true,
                'strict_variables' => false,
                'autoescape'       => true
            ]);

            $view->addExtension(new TwigExtension($c['router'], $base_path));
            $view->addExtension(new ViewHelper($c));

            return $view;
        };
    }

}
