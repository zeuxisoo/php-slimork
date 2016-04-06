<?php
namespace App\Models;

use App\Contracts\Model;

class User extends Model {

    protected $table    = 'user';

    protected $fillable = ['username', 'email', 'password'];

    protected $hidden   = ['password'];

}
