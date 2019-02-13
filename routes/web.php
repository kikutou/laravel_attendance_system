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
Route::get('/info', 'HomeController@info')->name('get_info')->middleware("auth");
Route::get('/info/{id}', 'HomeController@readinfo')->name('get_readinfo')->middleware("auth");



//出退勤管理　金
Route::get('/attendance', 'AttendanceRecordController@begin_finish_view')->name('begin_finish_view')->middleware("auth");
Route::post('/attendance', 'AttendanceRecordController@attendance_begin_finish')->name('attendance_begin_finish')->middleware("auth");

Route::get('/user_attendance_rec', 'AttendanceRecordController@create_csv')->name('get_create_csv')->middleware("auth");
Route::get('/user_attendance_rec_1', 'AttendanceRecordController@create_csv_find')->name('get_create_csv_find')->middleware('admin')->middleware("auth");

//tao
Route::get('user_a_week',"AttendanceRecordController@get_all")->name('get_user_all')->middleware("auth");
Route::get('user_find','AttendanceRecordController@user_find')->name('get_user_find')->middleware('admin')->middleware("auth");


//liang
//休み請求の一覧
Route::get('check/{staus?}',"LeavecheckController@check")->name("get_check")->middleware('admin')->middleware("auth");
//休み請求への操作
Route::post('check',"LeavecheckController@check")->name("post_check")->middleware('admin')->middleware("auth");
//会員認証請求の一覧
Route::get('mailcheck',"EmailcheckController@show_mail")->name("get_user_mail")->middleware('admin')->middleware("auth");
//会員認証請求への操作
Route::post('checkmail',"EmailcheckController@check_mail")->name("post_mail_check")->middleware('admin')->middleware("auth");
//遅刻照会の棒状チャート図
Route::get('adminchart', "HomeController@showchart")->name("get_adminchart")->middleware('admin')->middleware("auth");

//huang
Route::get('create_leave_request','AttendanceRecordController@create')->name('get_leave_request')->middleware('auth');
Route::post('store_leave_request','AttendanceRecordController@store')->name('post_leave_request')->middleware('auth');

//「通知関連」リンクをクリックすると、実行される。
Route::get('all_info','NoticeController@show_all_info')->name('get_all_info')->middleware('auth')->middleware('admin');

//SubMdalの「変更」ボタンをクリックすると、実行される。
Route::post('all_info','NoticeController@update_info')->name('post_updated_info')->middleware('auth')->middleware('admin');

//「お知らせ一覧」の右上の「お知らせの新規作成」をクリックすると、実行される。
Route::get('create_notice','NoticeController@create')->name('get_create_notice')->middleware('auth')->middleware('admin');

//「お知らせの新規作成」の「作成」ボタンをクリックすると、実行される。
Route::post('store_notice','NoticeController@store')->name('post_create_notice')->middleware('auth')->middleware('admin');
