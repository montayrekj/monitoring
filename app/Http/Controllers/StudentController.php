<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Schedule;
use App\Models\User;
use App\Models\Student;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function show($id) {
        if(Auth::user()->id != $id) {
            echo 'Invalid user';
            Auth::logout();
            return redirect('/login');
        }

        $user = DB::table('users')->find($id);

        if($user->accountType == "1") {
            $student = DB::table('students')->where('userId',$id)->first();
            $student->track = DB::table('tracks')->where('trackId', $student->trackId)->first()->name;

            $section = DB::table('sections')->where('sectionId', $student->sectionId)->first();
            $student->section = $section->name;

            $teacher = DB::table('teachers')->where('id', $section->teacherId)->first();
            $student->adviser = $teacher->firstName.' '.$teacher->lastName;

            $schedules = Schedule::getSchedulesBySection($student->sectionId);

            $timeframes = [];

            for($counter = 0; $counter < $schedules->count(); $counter++) {
                $str = $schedules[$counter]->timeFrom.' - '.$schedules[$counter]->timeTo;
                if(in_array($str ,$timeframes) != true) {
                    array_push($timeframes,$str);
                }
            }
        }
        return view('studentinfo', ['student'=>$student,'schedules'=>$schedules, 'timeframes'=>$timeframes, 'id'=>$id]);
    }

    public function showChangePassword($id) {
        if(Auth::user()->id != $id) {
            echo 'Invalid user';
            Auth::logout();
            return redirect('/login');
        }

        return view('studentChangePassword', ['id'=>$id]);
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
            return redirect('student/'.$id.'/changePassword/')->with('success','Successfully updated password.');
        } else {
            return redirect('student/'.$id.'/changePassword/')->with('error','Invalid current password entered.');
        }
    }

    public function showRegister() {
        $sections = DB::table('sections')->get();
        $tracks = DB::table('tracks')->get();

        return view('studentregister', ['sections'=>$sections, 'tracks'=>$tracks]);
    }

    public function register(Request $request) {
        $user = DB::table('users')->where('username', $request->username)->first();

        if($user != null) {
            return redirect('student/register')->with('error','Username exists.');
        }

        $user = new User();
        $user->username = $request->username;
        $user->password = $request->password;
        $user->accountType = 1;
        $user->save();

        $user = DB::table('users')->orderBy('id', 'desc')->first();
        $student = new Student();
        $student->userId = $user->id;
        $student->firstName = $request->firstname;
        $student->lastName = $request->lastname;
        $student->trackId = $request->section;
        $student->grade = $request->grade;
        $student->sectionId = $request->section;
        $student->save();

        return redirect('student/register')->with('success','Successfully registered!');
    }
}
