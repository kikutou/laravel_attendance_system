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
//tao
Route::get('user_a_week',"AttendenceRecordController@get_all")->name('get_user_all');
//liang
//缺勤请求一栏
Route::get('check/{staus?}',"LeavecheckController@check")->name("get_check");
Route::post('check',"LeavecheckController@check")->name("post_check");
//huang
Route::get('create_leave_request','AttendanceRecordController@create_leave_request')->name('get_leave_request');
Route::post('store_leave_request','AttendanceRecordController@store_leave_request')->name('post_leave_request');
