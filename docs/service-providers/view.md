# View

This service provider can provider `Twig` template engine in the application

## Installation

1. Open the default application config file named `app.php`

        vim config/app.php

2. Add/Enable the following line

        'providers' => [
            ...
            Slimork\Providers\View\ViewServiceProvider::class,
            ...
        ]

3. Edit the default view config like default charset, auto reload status and so on

        vim config/view.php

    - default cache path: `/storage/cache/views`

## Usage

You can access the view service provider by the following code

    $this->view->render($response, 'view.html';
    $this->view->render($response, 'view.html', compact('variable'));

In the controller, it can access by the following code

    $this->render('view.html');
    $this->render('view.html', compact('variable'));

## Extensions

This view service provider was providered base default extensions.

If you want to add your custom extension, please add the extension in the view config (`config/view.php`) like

    'extensions' => [
        Slimork\Providers\View\DefaultViewExtension::class,
        ...
        Your\Custom\View\Extension\MyCustomViewExtension::class
        ...
    ]

The custom extension may like

    <?php
    namespace Your\Custom\View\Extension;

    use Twig_SimpleFunction;
    use Twig_SimpleFilter;
    use Twig_SimpleTest;
    use Slimork\Contracts\ViewExtension;

    class MyCustomViewExtension extends ViewExtension {

        public function getName() {
            return 'MyCustomViewExtension';
        }

        public function getFunctions() {
            return [
                new Twig_SimpleFunction('name', [$this, 'method']),
            ];
        }

        public function getFilters() {
            return [
                new Twig_SimpleFilter('name', [$this, 'method']),
            ];
        }

        public function getTests() {
            return [
                new \Twig_SimpleTest('null', [$this, 'is_null']),
                new \Twig_SimpleTest('object', [$this, 'is_object']),
            ];
        }

        public function is_null($value) {
            return is_null($value);
        }

        public function is_object($value) {
            return is_object($value);
        }

    }
