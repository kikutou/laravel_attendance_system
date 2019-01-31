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
    return view('welcome');
});


Auth::routes(['verify' => true]);
Route::get('/verified', 'Auth\VerificationController@emailverified')->name('verified');
Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');
Route::get('/login', 'Auth\LoginController@login')->name('login');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

//infomation_index jiang
Route::get('/info', 'HomeController@info')->name('get_info');
Route::get('/info/{id}', 'HomeController@readinfo')->name('get_readinfo');



//出退勤管理　金
Route::get('/attendance', 'AttendanceRecordController@begin_finish_view')->name('begin_finish_view');
Route::post('/attendance', 'AttendanceRecordController@attendance_begin_finish')->name('attendance_begin_finish');
//tao
Route::get('user_a_week',"AttendanceRecordController@get_all")->name('get_user_all');
//liang
//缺勤请求一栏
Route::get('check/{staus?}',"LeavecheckController@check")->name("get_check")->middleware('admin');
Route::post('check',"LeavecheckController@check")->name("post_check")->middleware('admin');
Route::get('mailcheck',"EmailcheckController@show_mail")->name("get_user_mail")->middleware('admin');
Route::post('checkmail',"EmailcheckController@check_mail")->name("post_mail_check")->middleware('admin');

//huang
Route::get('create_leave_request','AttendanceRecordController@create_leave_request')->name('get_leave_request');
Route::post('store_leave_request','AttendanceRecordController@store_leave_request')->name('post_leave_request');
