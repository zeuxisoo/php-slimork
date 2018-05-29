<?php
namespace Slimork\Providers\View;

use Slim\Views\Twig;
use Slim\Views\TwigExtension;
use Slimork\Contracts\ServiceProvider;

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
        $this->container->set('view', function($container) {
            $settings = $container->get('settings');
            $request  = $container->get('request');
            $router   = $container->get('router');

            $view_path  = RESOURCE_ROOT.'/view';
            $cache_path = STORAGE_ROOT.'/cache/view';
            $base_path  = rtrim(str_ireplace('index.php', '', $request->getUri()->getBasePath()), '/');

            $view = new Twig($view_path, array_merge([
                'charset'          => 'utf-8',
                'auto_reload'      => true,
                'strict_variables' => false,
                'autoescape'       => 'html',

                'cache'            => $cache_path,
            ], $settings['view']['default']));

            $view->addExtension(new TwigExtension($router, $base_path));

            foreach($settings['view']['extensions'] as $extension) {
                $view->addExtension(new $extension($container));
            }

            return $view;
        });
    }

}
