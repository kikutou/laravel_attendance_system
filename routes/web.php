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

//Route::get('user_a_week',"AttendenceRecordController@show_index")->name('get_user_a_week');
Route::get('user_a_week',"AttendenceRecordController@get_all")->name('get_user_all');
