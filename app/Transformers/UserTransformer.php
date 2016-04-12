<?php
namespace App\Transformers;

use App\Contracts\Transformer;
use App\Models\User;

class UserTransformer extends Transformer {

    public function transform(User $user) {
        return [
            'id'         => $user->id,
            'username'   => $user->username,
            'email'      => $user->email,
            'created_at' => $user->created_at->toDateTimeString()
        ];
    }

}
