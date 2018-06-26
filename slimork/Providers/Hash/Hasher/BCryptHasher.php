<?php
namespace Slimork\Providers\Hash\Hasher;

use RuntimeException;
use Slimork\Contracts\Hasher;

class BCryptHasher extends Hasher {

    protected $rounds = 10;

    public function __construct($settings) {
        parent::__construct($settings);

        $this->rounds = $this->settings['rounds'] ?? $this->rounds;
    }

    public function make($value, array $options = []) {
        $hash = password_hash($value, PASSWORD_BCRYPT, array_merge([
            'cost' => $this->rounds,
        ], $options));

        if ($hash === false) {
            throw new RuntimeException('Cannot using the bcrypt hashing methods');
        }

        return $hash;
    }

    public function check($value, $hashed_value) {
        $password_info = $this->password_info($hashed_value);

        if ($password_info['algoName'] !== 'bcrypt') {
            throw new RuntimeException('This password is not encrypt by Bcrypt algorithm');
        }

        if (strlen($hashed_value) === 0) {
            return false;
        }else{
            return password_verify($value, $hashed_value);
        }
    }

    public function needsRehash($hashed_value, array $options = []) {
        return password_needs_rehash($hashed_value, PASSWORD_BCRYPT, array_merge([
            'cost' => $this->rounds,
        ], $options));
    }

}
