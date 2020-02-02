<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $userId
 * @property string $firstName
 * @property string $lastName
 */
class Teacher extends Model
{
    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['userId', 'firstName', 'lastName'];

    public function sections() {
        return $this->hasMany('App\Models\Section', 'teacherId');
    }

}
