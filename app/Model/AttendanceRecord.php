<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class AttendanceRecord extends Model
{
    public static $validator_rules = [

       'leave_start_hour' => 'required',
       'leave_start_minute' => 'required',
       'leave_end_hour' => 'required',
       'leave_end_minute' => 'required',
       'leave_reason' => 'required'
    ];

    public static $validator_messages = [

       'leave_start_hour.required' => '欠勤開始時間(時)を選択してください!',
       'leave_start_minute.required' => '欠勤開始時間(分)を選択してください!',
       'leave_end_hour.required' => '欠勤終了時間(時)を選択してください!',
       'leave_end_minute.required' => '欠勤終了時間(分)を選択してください!',
       'leave_reason.required' => '欠勤理由を入力してください!'
    ];
    protected $table = "attendance_records";
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'attendance_date'];

    public function users()
      {
        return $this->belongsTo("App\User", "user_id");
      }

    public function mtb_leave_check_status()
    {
      return $this->belongsTo("App\Model\Master\MtbLeaveCheckStatus", "mtb_leave_check_status_id");
    }

    public static function check_leave_time($user, $attendance_date, $leave_start_at, $leave_end_at)
    {
      $result = true;
      $attendance_record = self::where('user_id',$user->id)
        ->where('attendance_date',$attendance_date ?? Carbon::today())
        ->where('start_time','!=',null)
        ->where("end_time", "!=", null)
        ->first();

      if($attendance_record) {
        $cb_start_time = new Carbon($attendance_record->start_time);
        $cb_end_time = new Carbon($attendance_record->end_time);
        $cb_leave_start_at = new Carbon($leave_start_at);
        $cb_leave_end_at = new Carbon($leave_end_at);
        if($cb_start_time ->lt($cb_leave_start_at) &&  $cb_end_time->gt($cb_leave_end_at)) {
          $result = false;
        }

        if($cb_start_time->lt($cb_leave_end_at) && $cb_end_time->gt($cb_leave_end_at)) {
          $result = false;
        }

      }

      return $result;
    } 

}
