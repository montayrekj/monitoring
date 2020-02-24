<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Schedule;
use App\Models\Subject;
use App\Models\Attendance;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function show() {
        $schedules = Schedule::getAllSchedule();

        return view('admin.schedules.schedules', ['id'=>Auth::user()->id,'schedules'=>$schedules]);
    }

    public function showAdd() {
        $sections = DB::table('sections')->get();
        $subjects = DB::table('subjects')->get();

        for($counter = 0; $counter < $subjects->count(); $counter++) {
            $teacher = DB::table('teachers')->where('id',$subjects[$counter]->teacherId)->first();
            $subjects[$counter]->teacher = $teacher->firstName.' '.$teacher->lastName;
        }

        return view('admin.schedules.schedulesadd', ['id'=>Auth::user()->id,'sections'=>$sections, 'subjects'=>$subjects]);
    }

    public function addSchedule(Request $request) {
        $schedule = new Schedule();
        $schedule->subjectId = $request->subject;
        $schedule->sectionId = $request->section;
        $schedule->timeFrom = date('H:i', strtotime($request->timeFrom));
        $schedule->timeTo = date('H:i', strtotime($request->timeTo));
        $schedule->day = $request->day;
        $schedule->save();

        return redirect('/admin/schedules');
    }

    public function deleteSchedule($id) {
        $schedule = DB::table('schedules')->where('scheduleId',$id)->limit(1);
        $schedule->delete();

        return redirect('/admin/schedules');
    }

    public function showUpdate($id) {
        $schedule = DB::table('schedules')->where('scheduleId', $id)->first();
        $schedule->timeFrom = strftime('%H:%M', strtotime($schedule->timeFrom));
        $schedule->timeTo = strftime('%H:%M', strtotime($schedule->timeTo));
        $sections = DB::table('sections')->get();
        $subjects = DB::table('subjects')->get();

        for($counter = 0; $counter < $subjects->count(); $counter++) {
            $teacher = DB::table('teachers')->where('id',$subjects[$counter]->teacherId)->first();
            $subjects[$counter]->teacher = $teacher->firstName.' '.$teacher->lastName;
        }
        
        return view('admin.schedules.schedulesupdate', ['id'=>Auth::user()->id,'sections'=>$sections, 'subjects'=>$subjects, 'schedule'=>$schedule]);
    }

    public function updateSchedule(Request $request, $id) {
        $schedule = DB::table('schedules')->where('scheduleId',$id)->limit(1);

        $schedule->update([
            'subjectId' => $request->subject,
            'sectionId' => $request->section,
            'timeFrom' => date('H:i', strtotime($request->timeFrom)),
            'timeTo' => date('H:i', strtotime($request->timeTo)),
            'day'=> $request->day
        ]);

        return redirect('/admin/schedules');
    }
}
