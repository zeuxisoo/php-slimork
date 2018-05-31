<?php
if (function_exists('dd') === false) {
    function dd($obj) {
        dump($obj);
        die();
    }
}

if (function_exists('storage_path') === false) {
    function storage_path($path) {
        return STORAGE_ROOT.$path;
    }
}

if (function_exists('resources_path') === false) {
    function resources_path($path) {
        return RESOURCES_ROOT.$path;
    }
}

if (function_exists('render_template') === false) {
    function render_template($template_path, $template_name, $variables = []) {
        $loader = new \Twig_Loader_Filesystem($template_path);

        $twig = new \Twig_Environment($loader, [
            'charset'          => 'utf-8',
            'cache'            => false,
            'auto_reload'      => true,
            'strict_variables' => false,
            'autoescape'       => 'html',
        ]);

        $template = $twig->load($template_name);

        return $template->render($variables);
    }
}

if (function_exists('render_error') === false) {
    function render_error($template_name, $variables = []) {
        return render_template(resources_path('/views/errors'), $template_name, $variables);
    }
}
