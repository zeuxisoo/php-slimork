<?php
if (function_exists('dd') === false) {
    function dd($obj) {
        dump($obj);
        die();
    }
}
