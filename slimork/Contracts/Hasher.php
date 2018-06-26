<?php
namespace Slimork\Contracts;

abstract class Hasher {

    protected $settings;

    public function __construct($settings) {
        $this->settings = $settings;
    }

    public function password_info($value) {
        return password_get_info($value);
    }

    abstract public function make($value, array $options = []);
    abstract public function check($value, $hashed_value);
    abstract public function needsRehash($hashed_value, array $options = []);

}
