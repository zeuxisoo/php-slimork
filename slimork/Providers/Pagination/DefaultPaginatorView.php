<?php
namespace Slimork\Providers\Pagination;

use Slimork\Contracts\PaginatorView;

class DefaultPaginatorView implements PaginatorView {

    protected $view;
    protected $template;
    protected $variables;

    public function __construct($container) {
        $settings = $container->get('settings');

        $loader = new \Twig_Loader_Filesystem(RESOURCES_ROOT.'/views/paginations');
        $twig   = new \Twig_Environment($loader, [
            'charset'          => 'utf-8',
            'cache'            => false,
            'auto_reload'      => true,
            'strict_variables' => false,
            'autoescape'       => 'html',
        ]);

        if (array_key_exists('view', $settings) === true) {
            foreach($settings['view']['extensions'] as $extension) {
                $twig->addExtension(new $extension($container));
            }
        }else{
            $twig->addTest(new \Twig_SimpleTest('string', function($value) {
                return is_string($value);
            }));

            $twig->addTest(new \Twig_SimpleTest('array', function($value) {
                return is_array($value);
            }));
        }

        $this->view = $twig;
    }

    public function make($view, $data = [], $merge_data = []) {
        $this->template  = $this->view->load($view);
        $this->variables = array_merge($data, $merge_data);

        return $this;
    }

    public function render() {
        return $this->template->render($this->variables);
    }

}
