<?php
namespace Slimork\Providers\Csrf;

use Twig_SimpleFunction;
use Twig_Extension_GlobalsInterface;
use Slimork\Contracts\ViewExtension as SlimorkViewExtension;

class ViewExtension extends SlimorkViewExtension implements Twig_Extension_GlobalsInterface {

    public function getName() {
        return 'CsrfViewExtension';
    }

    /**
     * example:
     *
     *      # csrf
     *      <input type="hidden" name="{{csrf.keys.name}}" value="{{csrf.name}}">
     *      <input type="hidden" name="{{csrf.keys.value}}" value="{{csrf.value}}">
     *
     *      # csrf_metas
     *      <meta name='csrf_name' content='csrf_random_name' />
     *      <meta name='csrf_value' content='csrf_random_value' />
     *
     *      # csrf_tags
     *      <input type='hidden' name='csrf_name' value='csrf_random_name' />
     *      <input type='hidden' name='csrf_value' value='csrf_random_value' />
     *
     */
    public function getGlobals() {
        $csrf = $this->container->get('csrf');

        $csrf_name_key  = $csrf->getTokenNameKey();
        $csrf_value_key = $csrf->getTokenValueKey();

        $csrf_name  = $csrf->getTokenName($csrf_name_key);
        $csrf_value = $csrf->getTokenValue($csrf_value_key);

        return [
            'csrf' => [
                'keys' => [
                    'name'  => $csrf_name_key,
                    'value' => $csrf_value_key
                ],
                'name'  => $csrf_name,
                'value' => $csrf_value
            ],

            'csrf_metas' => new \Twig_Markup($csrf->getTokenForMetaTags(), 'UTF-8'),
            'csrf_tags'  => new \Twig_Markup($csrf->getTokenForHiddenInputTags(), 'UTF-8'),
        ];
    }

}
