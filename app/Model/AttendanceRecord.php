<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class AttendanceRecord extends Model
{
    public static $validator_rules = [
       'attendance_date' => 'required',
       'leave_start_time' => 'required|date_format:H:i',
       'leave_end_time' => 'required|date_format:H:i',
       'leave_reason' => 'required'
    ];

    public static $validator_messages = [
       'attendance_date.required' => '欠勤日をお選びください!',
       'leave_start_time.required' => '欠勤開始時間を入力してください!',
       'leave_start_time.date_format' => '欠勤開始時間の形式が間違っています!',
       'leave_end_time.required' => '欠勤終了時間を入力してください!',
       'leave_end_time.date_format' => '欠勤終了時間の形式が間違っています!',
       'leave_reason.required' => '欠勤理由を入力してください!'
    ];
    protected $table = "attendance_records";
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'attendance_date'];

    public function users()
      {
        return $this->belongsTo("App\Model\User", "user_id");
      }

    public function mtb_leave_check_status()
    {
      return $this->belongsTo("App\Model\MtbLeaveCheckStatus", "mtb_leave_check_status_id");
    }

    public static function check_leave_time($user, $attendance_date, $leave_start_at, $leave_end_at)
    {
      $result = true;

      $attendance_record = self::where('user_id',$user->id)
        ->where('attendance_date',$attendance_date)
        ->where('start_time','!=',null)
        ->where("end_time", "!=", null)
        ->first();

      if($attendance_record) {

        if($attendance_record->start_time->lt($leave_start_at) && $attendance_record->end_time->gt($leave_start_at)) {
          $result = false;
        }

        if($attendance_record->start_time->lt($leave_end_at) && $attendance_record->end_time->gt($leave_end_at)) {
          $result = false;
        }

      }


      return $result;
    }


}
