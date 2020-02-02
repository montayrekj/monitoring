<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return redirect(url('/login'));
});

Route::get('/login', 'LoginController@index');

Route::get('/logout', 'LoginController@logout');

Route::post('/auth', 'LoginController@login');

Route::get('/student/register', 'StudentController@showRegister');

Route::post('/student/register', 'StudentController@register');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/student/{id}', 'StudentController@show');

    Route::get('/attendance/{id}', 'AttendanceController@show');

    Route::get('/teacher/{id}', 'TeacherController@show');

    Route::get('/teacher/{id}/changePassword', 'TeacherController@showChangePassword');   
    
    Route::post('/teacher/{id}/changePassword', 'TeacherController@changePassword');

    Route::get('/student/{id}/changePassword', 'StudentController@showChangePassword');   
    
    Route::post('/student/{id}/changePassword', 'StudentController@changePassword');
 });

 Route::get('/punch/{id}', 'AttendanceController@punchTime');

 Route::get('/teacher/{id}/getSubjects/{sectionId}', 'TeacherController@getSubjects');

 Route::get('/teacher/{id}/getAttendance', 'TeacherController@getAttendance');  
 
