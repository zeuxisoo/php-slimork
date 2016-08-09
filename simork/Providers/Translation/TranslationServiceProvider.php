<?php
namespace Simork\Providers\Translation;

use Simork\Contracts\ServiceProvider;
use Symfony\Bridge\Twig\Extension\TranslationExtension;

/**
 * Usage
 * =====
 *
 * Translation:
 *
 *      # In controller
 *      $this->translation->trans('Hello World!');
 *
 *      # In view
 *      {{ 'Hello World!' | trans }}
 *      {{ 'Hello World! My name is %name%' | trans({'%name%': 'Cat'}) }}
 */
class TranslationServiceProvider extends ServiceProvider {

    public function register() {
        $translator = Translation::getInstance($this->container->settings['app']['translation'])->translator();

        $this->container['view']->addExtension(new TranslationExtension($translator));

        $this->container['translation'] = function() use ($translator) {
            return $translator;
        };
    }

}
