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

//出退勤管理　金
Route::get('/attendance', 'AttendanceRecordController@begin_finish_view')->name('begin_finish_view');
Route::post('/attendance', 'AttendanceRecordController@attendance_begin_finish')->name('attendance_begin_finish');
