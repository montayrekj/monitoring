<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use DateTime;

/**
 * @property int $scheduleId
 * @property int $sectionId
 * @property int $subjectId
 * @property string $timeFrom
 * @property string $timeTo
 * @property int $day
 */
class Schedule extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'scheduleId';

    /**
     * @var array
     */
    protected $fillable = ['sectionId', 'subjectId', 'timeFrom', 'timeTo', 'day'];

    public $subject = '';
    public $timeframe = '';
    public $dayOfWeek = '';

    public static function getSchedulesBySection($sectionId) {
        $schedules = DB::table('schedules')->where('sectionId', $sectionId)->orderBy('timeFrom','asc')->orderBy('day','asc')->get();
        
        for($counter = 0; $counter < $schedules->count(); $counter++) {
            $time = DateTime::createFromFormat( 'H:i:s', $schedules[$counter]->timeFrom);
            $schedules[$counter]->timeFrom = strftime('%I:%M %p', strtotime($schedules[$counter]->timeFrom));
            $schedules[$counter]->timeTo = strftime('%I:%M %p', strtotime($schedules[$counter]->timeTo));
            $schedules[$counter]->timeframe = $schedules[$counter]->timeFrom.' - '.$schedules[$counter]->timeTo;
            $schedules[$counter]->subject = DB::table('subjects')->where('subjectId', $schedules[$counter]->subjectId)->first()->name;
            
        }

        return $schedules;
    }

    public static function getAllSubjectsBySection($sectionId) {
        $schedules = DB::table('schedules')->where('sectionId', $sectionId)->orderBy('timeFrom','asc')->orderBy('day','asc')->get();
        $subjects = [];
        
        for($counter = 0; $counter < $schedules->count(); $counter++) {
            $subject = new \stdClass();
            $subject->id = $schedules[$counter]->scheduleId;

            $schedules[$counter]->timeFrom = strftime('%I:%M %p', strtotime($schedules[$counter]->timeFrom));
            $schedules[$counter]->timeTo = strftime('%I:%M %p', strtotime($schedules[$counter]->timeTo));
            $schedules[$counter]->timeframe = $schedules[$counter]->timeFrom.' - '.$schedules[$counter]->timeTo;
            $subjectObj = DB::table('subjects')->where('subjectId', $schedules[$counter]->subjectId)->first();
            $subject->name = $subjectObj->name.' - '.Schedule::getDayOfWeek($schedules[$counter]->day).' ('.$schedules[$counter]->timeframe.')';

            array_push($subjects, $subject);
        }

        return $subjects;
    }

    public static function getAllSchedule() {
        $schedules = DB::table('schedules')->orderBy('subjectId','asc')->get();

        for($counter = 0; $counter < $schedules->count(); $counter++) {
            $schedules[$counter]->timeFrom = strftime('%I:%M %p', strtotime($schedules[$counter]->timeFrom));
            $schedules[$counter]->timeTo = strftime('%I:%M %p', strtotime($schedules[$counter]->timeTo));
            $schedules[$counter]->timeframe = $schedules[$counter]->timeFrom.' - '.$schedules[$counter]->timeTo;
            $subject = DB::table('subjects')->where('subjectId', $schedules[$counter]->subjectId)->first();
            $schedules[$counter]->subject = $subject->name;
            $teacher = DB::table('teachers')->where('id', $subject->teacherId)->first();
            $schedules[$counter]->teacher = $teacher->firstName.' '.$teacher->lastName;
            $schedules[$counter]->section = DB::table('sections')->where('sectionId', $schedules[$counter]->sectionId)->first()->name;
            
            switch($schedules[$counter]->day) {
                case 1: $schedules[$counter]->dayOfTheWeek = 'Monday';
                break;
                case 2: $schedules[$counter]->dayOfTheWeek = 'Tuesday';
                break;
                case 3: $schedules[$counter]->dayOfTheWeek = 'Wednesday';
                break;
                case 4: $schedules[$counter]->dayOfTheWeek = 'Thursday';
                break;
                case 5: $schedules[$counter]->dayOfTheWeek = 'Friday';
                break;
            }
        }

        return $schedules;
    }

    public static function getScheduleById($scheduleId) {
        $schedule = DB::table('schedules')->where('scheduleId', $scheduleId)->first();

        $time = DateTime::createFromFormat( 'H:i:s', $schedule->timeFrom);
        $schedule->timeFrom = strftime('%I:%M %p', strtotime($schedule->timeFrom));
        $schedule->timeTo = strftime('%I:%M %p', strtotime($schedule->timeTo));
        $schedule->timeframe = $schedule->timeFrom.' - '.$schedule->timeTo;
        $schedule->subject = DB::table('subjects')->where('subjectId', $schedule->subjectId)->first()->name;
        $schedule->dayOfWeek = Schedule::getDayOfWeek($schedule->day);

        return $schedule;
    }

    public static function getDayOfWeek($day) {
        switch($day) {
            case 1: return 'MONDAY';
                break;
            case 2: return 'TUESDAY';
                break;
            case 3: return 'WEDNESDAY';
                break;
            case 4: return 'THURSDAY';
                break;
            case 5: return 'FRIDAY';
                break;
        }
    }

}
