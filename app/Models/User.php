<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property int $id
 * @property int $accountType
 * @property string $password
 * @property string $username
 */
class User extends Authenticatable
{
    /**
     * @var array
     */
    protected $fillable = ['accountType', 'password', 'username'];

    public $timestamps = false;

}
