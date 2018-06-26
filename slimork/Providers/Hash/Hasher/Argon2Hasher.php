<?php
namespace Slimork\Providers\Hash\Hasher;

use RuntimeException;
use Slimork\Contracts\Hasher;

class Argon2Hasher extends Hasher {

    protected $memory_cost = 1024;
    protected $threads     = 2;
    protected $time_cost   = 2;

    public function __construct($settings) {
        parent::__construct($settings);

        $this->memory_cost = $this->settings['memory_cost'] ?? $this->memory_cost;
        $this->threads     = $this->settings['threads'] ?? $this->threads;
        $this->time_cost   = $this->settings['time_cost'] ?? $this->time_cost;
    }

    public function make($value, array $options = []) {
        $hash = password_hash($value, PASSWORD_ARGON2I, array_merge([
            'memory_cost' => $this->memory_cost,
            'threads'     => $this->threads,
            'time_cost'   => $this->time_cost,
        ], $options));

        if ($hash === false) {
            throw new RuntimeException('Cannot using the Argon2 hashing methods');
        }

        return $hash;
    }

    public function check($value, $hashed_value) {
        $password_info = $this->password_info($hashed_value);

        if ($password_info['algoName'] !== 'argon2i') {
            throw new RuntimeException('This password is not encrypt by Argon2 algorithm');
        }

        if (strlen($hashed_value) === 0) {
            return false;
        }else{
            return password_verify($value, $hashed_value);
        }
    }

    public function needsRehash($hashed_value, array $options = []) {
        return password_needs_rehash($hashed_value, PASSWORD_ARGON2I, array_merge([
            'memory_cost' => $this->memory_cost,
            'threads'     => $this->threads,
            'time_cost'   => $this->time_cost,
        ], $options));
    }

}
