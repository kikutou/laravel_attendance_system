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

//huang
Route::get('create_leave_request','AttendanceRecordController@create_request_leave')->name('get_leave_request');
Route::post('store_leave_request','AttendanceRecordController@store_request_leave')->name('post_leave_request');
