<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property int $sectionId
 * @property string $name
 * @property int $teacherId
 */
class Section extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'sectionId';

    /**
     * @var array
     */
    protected $fillable = ['name', 'teacherId'];

    public $teacherName = '';

    public static function getSectionById($sectionId) {
        $section = DB::table('sections')->where('sectionId', $sectionId)->first();
        $teacher = DB::table('teachers')->where('id', $section->teacherId)->first();
        $section->teacherName = $teacher->firstName.' '.$teacher->lastName;

        return $section;
    }

    public static function getSectionsByTeacher($teacherId) {
        return DB::table('sections')->where('teacherId', $teacherId)->get();
    }
}
