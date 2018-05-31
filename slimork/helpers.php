<?php
if (function_exists('dd') === false) {
    function dd($obj) {
        dump($obj);
        die();
    }
}

function storage_path($path) {
    return STORAGE_ROOT.$path;
}

function resource_path($path) {
    return RESOURCE_ROOT.$path;
}

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

function render_error($template_name, $variables = []) {
    return render_template(resource_path('/view/errors'), $template_name, $variables);
}
