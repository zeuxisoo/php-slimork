<?php
namespace App\Helpers;

class StringHelper {

    public static function random($length = 16) {
        $characters  = "abcdefghijklmnopqrstuxyvwzABCDEFGHIJKLMNOPQRSTUXYVWZ-*#&@!?";
        $char_length = strlen($characters);

        $result = [];

        for ($i=0; $i<$length; $i++) {
            $index    = mt_rand(0, $char_length - 1);
            $result[] = $characters[$index];
        }

        return implode("", $result);
    }

    public static function length($value) {
        return mb_strlen($value);
    }

    public static function contains($text, $word) {
        if ($word !== "" && mb_strpos($text, $word) !== false) {
            return true;
        }

        return false;
    }

    public static function randomAlphaNumeric($length = 16) {
        $words = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return mb_substr(str_shuffle(str_repeat($words, $length)), 0, $length);
    }

}
