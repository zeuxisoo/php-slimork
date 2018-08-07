<?php
namespace App\Models;

use Slimork\Contracts\Model;

class User extends Model {

    protected $fillable = ['username', 'email', 'password'];

    protected $hidden   = ['password'];

}
