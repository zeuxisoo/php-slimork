<?php
namespace App\Providers\Debugbar;

use App\Contracts\ServiceProvider;

class DebugbarServiceProvider extends ServiceProvider {

    public function register() {
        // Setup debugbar
        $debug_bar = new StandardDebugbar($this->app);
        $renderer = $debug_bar->getJavascriptRenderer($this->baseUrl());

        // Get router object from container
        $router = $this->container->get('router');

        // Add url mapping for debug bar resource
        $router->map(['GET'], '/_debugbar/resources/{name}', function($request, $response, $args) use ($renderer) {
            $name = $args['name'];

            switch($name) {
                case 'css':
                    $css = $renderer->dumpCssAssets();

                    $response = $response->withHeader('Content-Type', 'text/css')->write($css);
                    break;
                case 'js':
                    $js = $renderer->dumpJsAssets();

                    $response = $response->withHeader('Content-Type', 'text/javascript')->write($js);
                    break;
                default:
                    throw new \RuntimeException('Can not match resource type');
                    break;
            }

            return $response;
        })->setName('debugbar.assets');

        $this->container['debugbar'] = function() use ($debug_bar) {
            return $debug_bar;
        };
    }

    protected function baseUrl() {
        $uri    = $this->container->request->getUri();
        $path   = $uri->getPath();
        $scheme = $uri->getScheme();
        $domain = $uri->getHost();
        $port   = $uri->getPort() == 80 || $uri->getPort() == null ? "" : ":".$uri->getPort();
        $uri    = sprintf("%s://%s%s", $scheme, $domain, $port);

        return $uri;
    }

}
