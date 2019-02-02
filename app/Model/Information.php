<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    protected $table = "informations";

    public static $validator_rules = [

      'show_date' => 'required',
      'title' =>'required',
      'comment' => 'required',
      'user_ids' => 'required'
    ];

    public static $validator_messages = [

      'show_date.required' => 'お知らせ日時を選択してください。',
      'title.required' => 'タイトルを入力してください。',
      'comment.required' => 'お知らせ内容を選択してください。',
      'user_ids.required' => '送信先を選択してください。'
    ];

    public function users_of_informations()
    {
        return $this->hasMany('App\Model\Users_of_information','information_id');
    }
}
