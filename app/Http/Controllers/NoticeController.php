<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Model\Information;
use App\Model\Users_of_information;
use Carbon\Carbon;
use Validator;

class NoticeController extends Controller
{
  /**
   *
   *お知らせの新規登録画面。
   *
   */
  public function create_notice(Request $request)
  {
    $users = User::all();
    return view('admin.create_notice',['users' => $users]);
  }

  /**
   *
   *お知らせのの新規登録機能。
   *
   */
  public function store_notice(Request $request)
  {
    $validator = Validator::make($request->all(),Information::$validator_rules,Information::$validator_messages);
    if($validator->fails()){
      return redirect()->back()->withInput()->withErrors($validator);
    }

    //日付が過去かどうかを確認する。
    $carbon = new Carbon($request->show_date);
    if($carbon->lt(Carbon::today())){
      $error_message = '本日以降の日付で選択してください！';
      return redirect()->back()->withInput()->with(['error' => $error_message]);
    }

    $one_info = new Information;
    $one_info->show_date = (!$request->show_date) ? Carbon::today() : new Carbon($request->show_date);
    $one_info->title = $request->title;
    $one_info->comment = $request->comment;

    if($one_info->save()){
      foreach($request->user_ids as $user_id){
        $one_pivot = new Users_of_information;
        $one_pivot->information_id = $one_info->id;
        $one_pivot->user_id = $user_id;
        $one_pivot->save();
      }
    }

    $success_message = '登録完了しました！';
    return redirect(route('get_all_info'))->with(['message' => $success_message]);
  }

  /**
   *
   *お知らせ一覧の表示。
   *
   */
  public function show_all_info(Request $request)
  {
    $all_infos = Information::get_all_infos_orderby();
    return view('admin.all_info',['all_infos' => $all_infos]);
  }

  /**
   *
   *お知らせの内容更新。
   *
   */
  public function update_info(Request $request)
  {
    $one_info = Information::where('id',$request->info_id)->first();
    $one_info->title = $request->title;
    $one_info->comment = $request->content;
    $one_info->save();

    $success_message = '更新しました。';
    return redirect(route('get_all_info'))->with(['message' => $success_message]);
  }
}
