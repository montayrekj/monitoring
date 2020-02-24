<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Schedule;
use App\Models\Teacher;
use App\Models\Attendance;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AdminTeacherController extends Controller
{
    public function show() {
        $teachers = DB::table('teachers')->get();

        for($counter = 0; $counter < $teachers->count(); $counter++) {
            $teachers[$counter]->name = $teachers[$counter]->firstName.' '.$teachers[$counter]->lastName;
        }

        return view('admin.teachers.teachers', ['id'=>Auth::user()->id,'teachers'=>$teachers]);
    }

    public function showAdd() {
        return view('admin.teachers.teachersadd', ['id'=>Auth::user()->id]);
    }

    public function addTeacher(Request $request) {
        $user = new User();

        $userExist = DB::table('users')->where('username',$request->username)->first();
        if($userExist != null) {
            return redirect('/admin/teachers/add')->with('error','Username already exists!');
        }

        $user->username = $request->username;
        $user->password = $request->password;
        $user->accountType = 0;
        $user->save();

        $teacher = new Teacher();
        $teacher->firstName = $request->firstname;
        $teacher->lastName = $request->lastname;
        $teacher->userId = $user->id;
        $teacher->save();

        return redirect('/admin/teachers');
    }

    public function deleteTeacher($id) {
        $teacher = DB::table('teachers')->where('id',$id)->limit(1);
        $teacher->delete();

        return redirect('/admin/teachers');
    }

    public function showUpdate($id) {
        $teacher = DB::table('teachers')->where('id',$id)->first();
        $user = DB::table('users')->where('id',$teacher->userId)->first();
        $teacher->username = $user->username;
        
        return view('admin.teachers.teachersupdate', ['id'=>Auth::user()->id, 'teacher'=>$teacher]);
    }

    public function updateTeacher(Request $request, $id) {
        $userExist = DB::table('users')->where('username',$request->username)->get();
        if($userExist->count() > 1) {
            return redirect('/admin/teachers/update/'.$id)->with('error','Username already exists!');
        }

        $userExist = DB::table('users')->where('password',$request->oldpassword)->first();
        if($userExist == null) {
            return redirect('/admin/teachers/update/'.$id)->with('error','Old password is incorrect!');
        }
        $teacher = DB::table('teachers')->where('id',$id)->limit(1);
        $teacher->update([
            'firstName' => $request->firstname,
            'lastName' => $request->lastname
        ]);

        $teacher = DB::table('teachers')->where('id',$id)->first();
        $user = DB::table('users')->where('id',$teacher->userId)->limit(1);
        $user->update([
            'username' => $request->username,
            'password' => $request->newpassword
        ]);

        // $subject = DB::table('subjects')->where('subjectId',$id)->limit(1);

        // $subject->update([
        //     'name' => $request->subjectname,
        //     'teacherId' => $request->subjectadviser
        // ]);

        return redirect('/admin/teachers');
    }
}
