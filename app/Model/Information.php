<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    protected $table = "informations";

    public static $validator_rules = [

      'title' =>'required',
      'comment' => 'required',
      'user_ids' => 'required'
    ];

    protected $dates = [
        'show_date',
    ];

    public static $validator_messages = [

      'title.required' => 'タイトルを入力してください。',
      'comment.required' => 'お知らせ内容を選択してください。',
      'user_ids.required' => '送信先を選択してください。'
    ];

    public function users_of_informations()
    {
        return $this->hasMany('App\Model\Users_of_information','information_id');
    }

    public function is_read(User $user) {

        $result = true;
        $user_info = Users_of_information::query()->where("user_id", $user->id)->where("information_id", $this->id)->first();
        if($user_info && !$user_info->read_at) {
            $result = false;
        }

        return $result;
    }

    public function get_pivot_id(User $user) {
        $user_info = Users_of_information::query()->where("user_id", $user->id)->where("information_id", $this->id)->first();
        if($user_info) {
            return $user_info->id;
        }
        return false;
    }
}
