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

       'attendance_date.required' => '休暇日をお選びください!',
       'leave_start_time.required' => '欠勤開始時間を入力してください!',
       'leave_start_time.date_format' => '欠勤開始時間の形式が間違っています!',
       'leave_end_time.required' => '欠勤終了時間を入力してください!',
       'leave_end_time.date_format' => '欠勤終了時間の形式が間違っています!',
       'leave_reason.required' => '欠勤理由を入力してください!'

    ];
}
