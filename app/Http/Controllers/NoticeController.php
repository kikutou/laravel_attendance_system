<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\User;
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
    return view('create_notice',['users' => $users]);
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

    $carbon = new Carbon($request->show_date);
    if($carbon->isPast()){
      $error_message = '本日以降の日付で選択してください！';
      return redirect()->back()->withInput()->with(['error' => $error_message]);
    }

    $one_info = new Information;
    $one_info->show_date = new Carbon($request->show_date);
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
    return redirect()->back()->with(['message' => $success_message]);
  }
}
