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

class AdminController extends Controller
{
    public function show() {
        if(!Auth::check()) {
            echo 'Invalid user';
            Auth::logout();
            return redirect('/login');
        }
        $id = Auth::user()->id;
        $sections = DB::table('sections')->get();

        return redirect('/admin/sections');
    }

    public function showChangePassword() {
        if(!Auth::check()) {
            echo 'Invalid user';
            Auth::logout();
            return redirect('/login');
        }
        $id = Auth::user()->id;
        return view('admin.changepassword', ['id'=>$id]);
    }

    public function changePassword(Request $request) {
        if(!Auth::check()) {
            echo 'Invalid user';
            Auth::logout();
            return redirect('/login');
        }
        $id = Auth::user()->id;
        $user = User::where('password', $request->currentPassword)->where('id', $id)->first();

        if($user != null) { 
            $user = User::where('password', $request->currentPassword)->where('id', $id)->limit(1);
            $user->update([
                'password' => $request->newPassword
            ]);
            return redirect('admin/'.$id.'/changePassword/')->with('success','Successfully updated password.');
        } else {
            return redirect('admin/'.$id.'/changePassword/')->with('error','Invalid current password entered.');
        }
    }
}
