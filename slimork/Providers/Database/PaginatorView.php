<?php
namespace Slimork\Providers\Database;

class PaginatorView {

    protected $view;
    protected $template;
    protected $variables;

    public function __construct($container) {
        $settings = $container->get('settings');

        $loader = new \Twig_Loader_Filesystem(RESOURCES_ROOT.'/views');
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

    /*
     * Reference: https://github.com/laravel/framework/blob/5.6/src/Illuminate/Pagination/Paginator.php#L108
     */
    public function make($view, $data = [], $merge_data = []) {
        $view_file_path = str_replace('::', '/', $view).'.html';

        $this->template  = $this->view->load($view_file_path);
        $this->variables = array_merge($data, $merge_data);

        return $this;
    }

    /*
     * Reference: https://github.com/laravel/framework/blob/5.6/src/Illuminate/Pagination/Paginator.php#L107-L111
     */
    public function render() {
        return $this->template->render($this->variables);
    }

}
