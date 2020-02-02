<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property int $id
 * @property int $studentId
 * @property int $scheduleId
 * @property string $date
 * @property string $timeIn
 * @property int $timeInRemarks
 * @property string $timeOut
 * @property int $timeOutRemarks
 */
class Attendance extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'attendance';

    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['studentId', 'scheduleId', 'date', 'timeIn', 'timeInRemarks', 'timeOut', 'timeOutRemarks'];

    public $studentName = '';

    public static function getAttendanceByDate($scheduleId, $date) {
        $schedule = DB::table('schedules')->where('scheduleId', $scheduleId)->first();
        $allStudents = DB::table('students')->where('sectionId', $schedule->sectionId)->get();
        $attendanceList = [];

        for($counter = 0; $counter < $allStudents->count(); $counter++) {
            
            $attendance = DB::table("attendance")->where('studentId',$allStudents[$counter]->id)->where('scheduleId', $scheduleId)->where('date', $date)->first();

            if($attendance == null) {

                $attendance = new Attendance();
                $attendance->studentId = $allStudents[$counter]->id;
                $attendance->scheduleId = $scheduleId;
                $attendance->date = $date;
                $attendance->save();

                $student = DB::table('students')->where('id',$allStudents[$counter]->id)->first();
                $attendance = DB::table("attendance")->where('studentId',$allStudents[$counter]->id)->where('scheduleId', $scheduleId)->where('date', $date)->first();
                $attendance->studentName = $student->firstName.' '.$student->lastName;
                $attendance->timeIn = '';
                $attendance->timeOut = '';
                $attendance->timeInRemarks = '';
                $attendance->timeOutRemarks = '';  
                
                
            } else {
                $student = DB::table('students')->where('id',$attendance->studentId)->first();
                $attendance->studentName = $student->firstName.' '.$student->lastName;
                $attendance->timeIn = $attendance->timeIn != null? $attendance->timeIn : '';
                $attendance->timeOut = $attendance->timeOut != null? $attendance->timeOut : '';
                $attendance->timeInRemarks = $attendance->timeInRemarks != null? $attendance->timeInRemarks : '';
                $attendance->timeOutRemarks = $attendance->timeOutRemarks != null? $attendance->timeOutRemarks : '';
            }

            array_push($attendanceList, $attendance);
        }
        // $attendance = DB::table("attendance")->where('scheduleId', $scheduleId)->where('date', $date)->get();

        
        // for($counter = 0; $counter < $attendance->count(); $counter++) {
        //     $student = DB::table('students')->where('id',$attendance[$counter]->studentId)->first();
        //     $attendance[$counter]->studentName = $student->firstName.' '.$student->lastName;
        //     $attendance[$counter]->timeInRemarks = $attendance[$counter]->timeInRemarks != null? $attendance[$counter]->timeInRemarks : '';
        //     $attendance[$counter]->timeOutRemarks = $attendance[$counter]->timeOutRemarks != null? $attendance[$counter]->timeOutRemarks : '';
        // }
        
        return $attendanceList;
    }

    public static function checkAttendanceExistFirst($studentId, $scheduleId, $date) {
        return $attendance = DB::table("attendance")->where('studentId', $studentId)->where('scheduleId', $scheduleId)->where('date', $date)->first();
    }

    public static function checkAttendanceExistLimitOne($studentId, $scheduleId, $date) {
        return $attendance = DB::table("attendance")->where('studentId', $studentId)->where('scheduleId', $scheduleId)->where('date', $date)->limit(1);
    }
}
