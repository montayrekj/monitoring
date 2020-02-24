<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Attendance;
use App\Models\Section;
use App\Models\Schedule;
use App\Models\Subject;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function show(Request $request, $id) {
        if(Auth::user()->id != $id) {
            echo 'Invalid user';
            Auth::logout();
            return redirect('/login');
        }

        $student = $student = DB::table('students')->where('userId',$id)->first();
        $attendance = DB::table('attendance')->where('studentId', $student->id)->where('scheduleId', $request->scheduleId)->get();
        $schedule = Schedule::getScheduleById($request->scheduleId);
        $subject = Subject::getSubjectById($schedule->subjectId);//DB::table('subjects')->where('subjectId', $schedule->subjectId)->first();
        $section = Section::getSectionById($student->sectionId);

        return view('attendance', ['attendance'=>$attendance, 'subject'=>$subject, 'section'=>$section, 'schedule'=>$schedule, 'id'=>$id]);
    }

    public function punchTime($id) {
        date_default_timezone_set("Asia/Manila");
        $timeN = time(); 
        $student = $student = DB::table('students')->where('id',$id)->first();
        $schedules = DB::table('schedules')->where('sectionId', $student->sectionId)->orderBy('timeFrom','asc')->orderBy('day','asc')->get();
        $scheduleCount = -1;
        $scheduleId = -1;
        
        for($counter = 0; $counter < $schedules->count(); $counter++) {
            $timeF = strtotime($schedules[$counter]->timeFrom) - 900;
            $timeT = strtotime($schedules[$counter]->timeTo) + 900;
            
            if(($timeN >= $timeF && $timeN <= $timeT) && (date('w') == $schedules[$counter]->day)) {
                $schedules[$counter]->subject = DB::table('subjects')->where('subjectId', $schedules[$counter]->subjectId)->first()->name;
                $scheduleId = $schedules[$counter]->scheduleId;
                $scheduleCount = $counter;
                break;
            }
        }

        if($scheduleId != -1) {
            $attendance = Attendance::checkAttendanceExistFirst($student->id, $scheduleId, date('Y-m-d', $timeN));

            if($attendance == null) {
                $attendance = new Attendance();
                $attendance->studentId = $student->id;
                $attendance->scheduleId = $scheduleId;
                $attendance->date = date('Y-m-d', $timeN);
                $attendance->timeIn = date("H:i:s", $timeN);

                $timeLate = strtotime($schedules[$counter]->timeFrom) + 960;
                if($timeN >= $timeLate) {
                    $attendance->timeInRemarks = "LATE";
                }

                $attendance->save();

                return 'Successfully timed-in for '. $schedules[$scheduleCount]->subject .'!';
            } else {
                if($attendance->timeOut == null) {
                    $attendance = Attendance::checkAttendanceExistLimitOne($student->id, $scheduleId, date('Y-m-d', $timeN));
                    $attendance->update([
                        'timeOut' => date("H:i:s", $timeN)
                    ]);
                    return 'Successfully timed-out for '. $schedules[$scheduleCount]->subject .'!';
                } else if($attendance->timeIn == null) {
                    $attendance = Attendance::checkAttendanceExistLimitOne($student->id, $scheduleId, date('Y-m-d', $timeN));
                    $timeLate = strtotime($schedules[$counter]->timeFrom) + 960;
                    $remarks = "";
                    if($timeN >= $timeLate) {
                        $remarks = "LATE";
                    }
                
                    $attendance->update([
                        'remarks' => $remarks,
                        'timeIn' => date("H:i:s", $timeN)
                    ]);
                    return 'Successfully timed-in for '. $schedules[$scheduleCount]->subject .'!';
                } else {
                    return 'Already timed-in and timed-out for '. $schedules[$scheduleCount]->subject .'!';
                }
            }
        } else {
            return "No schedule for current day and time.";
        }
    }
}
