<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property int $subjectId
 * @property string $name
 * @property int $teacherId
 */
class Subject extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'subjectId';

    /**
     * @var array
     */
    protected $fillable = ['name', 'teacherId'];

    public $teacherName = '';

    public static function getSubjectById($subjectId) {
        $subject = DB::table('subjects')->where('subjectId', $subjectId)->first();
        $teacher = DB::table('teachers')->where('id', $subject->teacherId)->first();
        $subject->teacherName = $teacher->firstName.' '.$teacher->lastName;

        return $subject;
    }
}
