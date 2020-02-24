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
    
    //Teacher routes
    Route::get('/teacher/{id}', 'TeacherController@show');

    Route::get('/teacher/{id}/changePassword', 'TeacherController@showChangePassword');   
    
    Route::post('/teacher/{id}/changePassword', 'TeacherController@changePassword');

    Route::get('/attendance/{id}', 'AttendanceController@show');

    //Student routes
    Route::get('/student/{id}', 'StudentController@show');

    Route::get('/student/{id}/changePassword', 'StudentController@showChangePassword');   
    
    Route::post('/student/{id}/changePassword', 'StudentController@changePassword');

    //Admin routes
    Route::get('/admin', 'AdminController@show');

    Route::get('/admin/changePassword', 'AdminController@showChangePassword');   
    
    Route::post('/admin/changePassword', 'AdminController@changePassword');

    //Admin Sections

    Route::get('/admin/sections', 'SectionController@show');

    Route::get('/admin/sections/add', 'SectionController@showAdd');

    Route::post('/admin/sections/add', 'SectionController@addSection');

    Route::get('/admin/sections/delete/{id}', 'SectionController@deleteSection');

    Route::get('/admin/sections/update/{id}', 'SectionController@showUpdate');

    Route::post('/admin/sections/update/{id}', 'SectionController@updateSection');

    //Admin Subjects

    Route::get('/admin/subjects', 'SubjectController@show');

    Route::get('/admin/subjects/add', 'SubjectController@showAdd');

    Route::post('/admin/subjects/add', 'SubjectController@addSubject');

    Route::get('/admin/subjects/delete/{id}', 'SubjectController@deleteSubject');

    Route::get('/admin/subjects/update/{id}', 'SubjectController@showUpdate');

    Route::post('/admin/subjects/update/{id}', 'SubjectController@updateSubject');

    //Admin Teachers

    Route::get('/admin/teachers', 'AdminTeacherController@show');

    Route::get('/admin/teachers/add', 'AdminTeacherController@showAdd');

    Route::post('/admin/teachers/add', 'AdminTeacherController@addTeacher');

    Route::get('/admin/teachers/delete/{id}', 'AdminTeacherController@deleteTeacher');

    Route::get('/admin/teachers/update/{id}', 'AdminTeacherController@showUpdate');

    Route::post('/admin/teachers/update/{id}', 'AdminTeacherController@updateTeacher');

    //Admin Schedules

    Route::get('/admin/schedules', 'ScheduleController@show');

    Route::get('/admin/schedules/add', 'ScheduleController@showAdd');

    Route::post('/admin/schedules/add', 'ScheduleController@addSchedule');

    Route::get('/admin/schedules/delete/{id}', 'ScheduleController@deleteSchedule');

    Route::get('/admin/schedules/update/{id}', 'ScheduleController@showUpdate');

    Route::post('/admin/schedules/update/{id}', 'ScheduleController@updateSchedule');
 });

 Route::get('/punch/{id}', 'AttendanceController@punchTime');

 Route::get('/teacher/{id}/getSubjectDay', 'TeacherController@getSubjectDay');

 Route::get('/teacher/{id}/getSubjects/{sectionId}', 'TeacherController@getSubjects');

 Route::get('/teacher/{id}/getAttendance', 'TeacherController@getAttendance');  
 
