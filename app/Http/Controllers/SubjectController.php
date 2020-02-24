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

class SubjectController extends Controller
{
    public function show() {
        $subjects = DB::table('subjects')->get();

        for($counter = 0; $counter < $subjects->count(); $counter++) {
            $teacher = DB::table('teachers')->where('id',$subjects[$counter]->teacherId)->first();
            $subjects[$counter]->teacherName = $teacher->firstName.' '.$teacher->lastName;
        }

        return view('admin.subjects.subjects', ['id'=>Auth::user()->id,'subjects'=>$subjects]);
    }

    public function showAdd() {
        $teachers = DB::table('teachers')->get();

        return view('admin.subjects.subjectsadd', ['id'=>Auth::user()->id,'teachers'=>$teachers]);
    }

    public function addSubject(Request $request) {
        $subject = new Subject();
        $subject->name = $request->subjectname;
        $subject->teacherId = $request->subjectadviser;
        $subject->save();

        return redirect('/admin/subjects');
    }

    public function deleteSubject($id) {
        $subject = DB::table('subjects')->where('subjectId',$id)->limit(1);
        $subject->delete();

        return redirect('/admin/subjects');
    }

    public function showUpdate($id) {
        $teachers = DB::table('teachers')->get();
        $subject = DB::table('subjects')->where('subjectId',$id)->first();
        
        return view('admin.subjects.subjectsupdate', ['id'=>Auth::user()->id, 'subject'=>$subject, 'teachers'=>$teachers]);
    }

    public function updateSubject(Request $request, $id) {
        $subject = DB::table('subjects')->where('subjectId',$id)->limit(1);

        $subject->update([
            'name' => $request->subjectname,
            'teacherId' => $request->subjectadviser
        ]);

        return redirect('/admin/subjects');
    }
}
