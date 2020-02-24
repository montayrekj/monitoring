<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    public function index() {
        return view('login');
    }

    public function login(Request $request) {
        $user = User::where('username', $request->username)->where('password', $request->password)->first();

        if($user != null) {
            Auth::login($user);
            if($user->accountType == "1") {
                return redirect("/student/".$user->id);
            } else if($user->accountType == "0"){
                return redirect("/teacher/".$user->id);
            } else {
                return redirect("/admin");
            }
        } else {
            return redirect('/login')->with('error','Invalid username or password');
        }
    }

    public function logout() {
        Auth::logout();
        return redirect('/login');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
