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
  //(get形式)Route::name(get_create_notice)が実行されると、アクションが行われる。
  public function create(Request $request)
  {
    //データベースのusersテーブルから管理員より承認済みのuserデータを全て抽出。
    $users = User::whereNotNull('email_verified_at')->get();

    //上記のデータをView:admin.create_noticeに渡す。
    return view('admin.create_notice',['users' => $users]);
  }

  /**
   *
   *お知らせのの新規登録機能。
   *
   */
  //(post形式)Route::name(post_create_notice)が実行されると、アクションが行われる。
  public function store(Request $request)
  {
    //Model:Informationのvalidator_rules、validator_messageを使用して、Validation処理を行う。
    $validator = Validator::make($request->all(),Information::$validator_rules,Information::$validator_messages);
    if($validator->fails()){
      //Validationを通過しなかった場合、「お知らせの新規作成」画面にリダイレクトし、入力された内容とともにValidationメッセージが表示される。
      return redirect()->back()->withInput()->withErrors($validator);
    }

    //入力された内容がすべて問題ない場合、データベースのinformationsテーブルに新規データを書き込む。
    $one_info = new Information;

     //公開日時が入力されていない場合、デフォルトで本日とみなされる。
    $one_info->show_date = new Carbon($request->show_date) ??  Carbon::today();

    $one_info->title = $request->title;
    $one_info->comment = $request->comment;

     //informationsテーブルへの書き込みが終わったら、さらにusersテーブルとの中間テーブル(users_of_informations)への新規書き込みを行う。
    if($one_info->save()){
      foreach($request->user_ids as $user_id){
        $one_pivot = new Users_of_information;
        $one_pivot->information_id = $one_info->id;
        $one_pivot->user_id = $user_id;
        $one_pivot->save();
      }
    }
     //すべてが無事に終了した場合、「お知らせ一覧」画面にリダイレクトし、以下のメッセージを表示する。
    $success_message = '登録完了しました！';
    return redirect(route('get_all_info'))->with(['message' => $success_message]);
  }

  /**
   *
   *お知らせ一覧の表示。
   *
   */
  //(get形式)Route::name('get_all_info')が実行されると、アクションが行われる。
  public function show_all_info(Request $request)
  {
    //データベースのinformationsテーブルから全てのデータを公開日時を降順ソートしてから抽出。
    $all_infos = Information::get_all_infos_orderby();

    //抽出したデータをview:admin.all_infoに渡す。
    return view('admin.all_info',['all_infos' => $all_infos]);
  }

  /**
   *
   *お知らせの内容更新。
   *
   */
  //(post形式)Route::name(post_updated_info)が実行されると、アクションが行われる。
  public function update_info(Request $request)
  {
    //view:admin.all_infoのformからpostされたidをもとに該当Informationのデータを抽出。
    $one_info = Information::where('id',$request->info_id)->first();

    //formからpostされたtitle、commentを上記のデータに上書きする。
    $one_info->title = $request->title;
    $one_info->comment = $request->comment;
    $one_info->save();

    //更新が成功したら、「お知らせ一覧」にリダイレクトし、それと同時に以下のメッセージを表示。
    $success_message = '更新しました。';
    return redirect(route('get_all_info'))->with(['message' => $success_message]);
  }
}
