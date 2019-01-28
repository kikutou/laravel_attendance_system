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
//缺勤请求一栏
Route::get('check/{staus?}',"LeavecheckController@check")->name("get_check");
Route::post('check',"LeavecheckController@check")->name("post_check");
