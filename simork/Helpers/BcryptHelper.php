<?php
namespace Simork\Helpers;

/**
 * Usage
 * =====
 *
 * use Simork\Helpers\BcryptHelper;
 *
 * $bcrypt = new BcryptHelper();
 *
 * // Hash string
 * echo $bcrypt->make('string');
 *
 * // Verify hashing
 * $bcrypt->check('string', 'hashed_string');
 *
 * // Check a newer hashing algorithm is not available or the cost has changed
 * $bcrypt->needsRehash('hashed_string');
 *
 */
class BcryptHelper {

    protected $options = [
        'rounds' => 10,
    ];

    public function make($value, array $options = []) {
        $options = array_merge($this->options, $options);
        $hash    = password_hash($value, PASSWORD_BCRYPT, $options);

        if ($hash === false) {
            throw new RuntimeException('Hashing using bcrypt algorithm is not supported.');
        }

        return $hash;
    }

    public function check($value, $hashed_value) {
        if (strlen($hashed_value) === 0) {
            return false;
        }else{
            return password_verify($value, $hashed_value);
        }
    }

    public function needsRehash($hashed_value, array $options = []) {
        $options = array_merge($this->options, $options);

        return password_needs_rehash($hashed_value, PASSWORD_BCRYPT, $options);
    }

}
