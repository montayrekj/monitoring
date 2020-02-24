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

class SectionController extends Controller
{
    public function show() {
        $sections = DB::table('sections')->get();

        for($counter = 0; $counter < $sections->count(); $counter++) {
            $teacher = DB::table('teachers')->where('id',$sections[$counter]->teacherId)->first();
            $sections[$counter]->teacherName = $teacher->firstName.' '.$teacher->lastName;
        }

        return view('admin.sections.sections', ['id'=>Auth::user()->id,'sections'=>$sections]);
    }

    public function showAdd() {
        $teachers = DB::table('teachers')->get();

        return view('admin.sections.sectionsadd', ['id'=>Auth::user()->id,'teachers'=>$teachers]);
    }

    public function addSection(Request $request) {
        $section = new Section();
        $section->name = $request->sectionname;
        $section->teacherId = $request->sectionadviser;
        $section->save();

        return redirect('/admin/sections');
    }

    public function deleteSection($id) {
        $section = DB::table('sections')->where('sectionId',$id)->limit(1);
        $section->delete();

        return redirect('/admin/sections');
    }

    public function showUpdate($id) {
        $teachers = DB::table('teachers')->get();
        $section = DB::table('sections')->where('sectionId',$id)->first();
        
        return view('admin.sections.sectionsupdate', ['id'=>Auth::user()->id, 'section'=>$section, 'teachers'=>$teachers]);
    }

    public function updateSection(Request $request, $id) {
        $section = DB::table('sections')->where('sectionId',$id)->limit(1);

        $section->update([
            'name' => $request->sectionname,
            'teacherId' => $request->sectionadviser
        ]);

        return redirect('/admin/sections');
    }
}
