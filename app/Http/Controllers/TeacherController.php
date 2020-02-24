<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Schedule;
use App\Models\Section;
use App\Models\Attendance;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function show($id) {
        if(Auth::user()->id != $id) {
            echo 'Invalid user';
            Auth::logout();
            return redirect('/login');
        }

        $sections = DB::table('sections')->get();

        return view('teacherhome', ['sections'=>$sections, 'id'=>$id]);
    }

    public function showChangePassword($id) {
        if(Auth::user()->id != $id) {
            echo 'Invalid user';
            Auth::logout();
            return redirect('/login');
        }

        return view('teacherChangePassword', ['id'=>$id]);
    }

    public function changePassword(Request $request, $id) {
        if(Auth::user()->id != $id) {
            echo 'Invalid user';
            Auth::logout();
            return redirect('/login');
        }

        $user = User::where('password', $request->currentPassword)->first();

        if($user != null) { 
            $user = User::where('password', $request->currentPassword)->limit(1);
            $user->update([
                'password' => $request->newPassword
            ]);
            return redirect('teacher/'.$id.'/changePassword/')->with('success','Successfully updated password.');
        } else {
            return redirect('teacher/'.$id.'/changePassword/')->with('error','Invalid current password entered.');
        }
    }

    public function getSubjects($id, $sectionId) {
        // if(Auth::user()->id != $id) {
        //     echo 'Invalid user';
        //     Auth::logout();
        //     return redirect('/login');
        // }

        $subjects = Schedule::getAllSubjectsBySection($sectionId);

        return json_encode($subjects);
    }

    public function getSubjectDay(Request $request, $id) {
        // if(Auth::user()->id != $id) {
        //     echo 'Invalid user';
        //     Auth::logout();
        //     return redirect('/login');
        // }

        $subjectDay = DB::table('schedules')->where('scheduleId',$request->scheduleId)->first()->day;

        return json_encode($subjectDay);
    }

    public function getAttendance(Request $request, $id) {
        // if(Auth::user()->id != $id) {
        //     echo 'Invalid user';
        //     Auth::logout();
        //     return redirect('/login');
        // }
        $dateUnformatted = date_create($request->date);
        $date = date_format($dateUnformatted, 'Y-m-d');
        $attendance = Attendance::getAttendanceByDate($request->scheduleId, $date);

        return json_encode($attendance);
    }
}
