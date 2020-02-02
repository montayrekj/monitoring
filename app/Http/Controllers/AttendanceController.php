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
        $student = $student = DB::table('students')->where('userId',$id)->first();
        $schedules = DB::table('schedules')->where('sectionId', $student->sectionId)->orderBy('timeFrom','asc')->orderBy('day','asc')->get();
        $scheduleId = -1;
        
        for($counter = 0; $counter < $schedules->count(); $counter++) {
            $timeF = strtotime($schedules[$counter]->timeFrom);
            $timeT = strtotime($schedules[$counter]->timeTo);
            
            if(($timeN >= $timeF && $timeN <= $timeT) && (date('w') == $schedules[$counter]->day)) {
                $scheduleId = $schedules[$counter]->scheduleId;
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
                $attendance->save();
                //Calculate Remarks Below
            } else {
                if($attendance->timeOut == null) {
                    $attendance = Attendance::checkAttendanceExistLimitOne($student->id, $scheduleId, date('Y-m-d', $timeN));
                    $attendance->update([
                        'timeOut' => date("H:i:s", $timeN)
                    ]);
                } else if($attendance->timeIn == null) {
                    $attendance = Attendance::checkAttendanceExistLimitOne($student->id, $scheduleId, date('Y-m-d', $timeN));
                    $attendance->update([
                        'timeIn' => date("H:i:s", $timeN)
                    ]);
                }
                //Calculate Remarks Below
            }
            return 'Successfully punched!';
        } else {
            return "No schedule for current day and time.";
        }
    }
}
