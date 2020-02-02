<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $userId
 * @property string $firstName
 * @property string $lastName
 * @property int $grade
 * @property int $sectionId
 * @property int $trackId
 */
class Student extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['userId', 'firstName', 'lastName', 'grade', 'sectionId', 'trackId'];

    public $timestamps = false;

    public $section = '';
    public $track = '';
    public $adviser = '';
    public $schedules = [];

}
