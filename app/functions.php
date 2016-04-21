<?php
use App\Providers\Translation\Translation;

function lang($message, $arguments = array(), $domain = null, $locale = null) {
    $settings   = require CONFIG_ROOT.'/app.php';
    $translator = Translation::getInstance($settings['translation'])->translator();

    return $translator->trans($message, $arguments, $domain, $locale);
}

