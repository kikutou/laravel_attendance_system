<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\AttendanceRecord;
use Carbon\Carbon;
use App\Model\User;
use App\Model\Master\MtbLeaveCheckStatuse;
use Validator;

class AttendanceRecordController extends Controller
{
  /**
   *
   *休暇申請画面の表示。
   *
   */
   public function create_leave_request(Request $request)
   {
     return view('leave_request');
   }

   /**
    *
    *休暇申請機能。
    *
    */
    public function store_leave_request(Request $request)
    {
      $validator = Validator::make($request->all(),AttendanceRecord::$validator_rules,AttendanceRecord::$validator_messages);

      if($validator->fails()){
        return redirect()->back()->withInput()->withErrors($validator);
      }
      //日付が過去かどうかを確認する。
      $carbon = new Carbon($request->attendance_date);
      if($carbon->isPast()){
        $one_message = "形式が間違っています!本日以降の日付をお選びください。";
        return redirect()->back()->withInput()->with(['one_message' => $one_message]);
      }

      //$user = Auth::user();
      $one_attendance_record = AttendanceRecord::where('user_id', 1)
                                                ->where('attendance_date',$request->attendance_date)
                                                ->first();

      $another_attendance_record = AttendanceRecord::where('user_id',1)
                                                   ->where('attendace_date',$request->attendace_date)
                                                   ->where('start_time','!=',null)
                                                   ->where('end_time',"!=",null)
                                                   ->first();

      $start_time = new Carbon($one_attendance_record->start_time);
      $end_time = new Carbon($one_attendance_record->end_time);
      $leave_start_time = new Carbon($request->leave_start_time);
      $leave_end_time = new Carbon($request->leave_end_time);

      if($another_attendance_record && $end_time->gt($leave_start_time)){
        $one_message = "出勤時間外の時間で申請してください!";
        return redirect()->back()->with(['one_message' => $one_message]);
      }

      if(!$one_attendance_record){
        $one_attendance_record = new AttendanceRecord;
        $one_attendance_record->user_id = 1;
        $one_attendance_record->attendance_date = $request->attendance_date;
        $one_attendance_record->leave_start_time = $request->leave_start_time;
        $one_attendance_record->leave_end_time = $request->leave_end_time;
        $one_attendance_record->leave_reason = $request->leave_reason;
        $one_attendance_record->mtb_leave_check_status_id = MtbLeaveCheckStatuse::APPROVAL_PENDING;
        $one_attendance_record->save();

      }
      if($one_attendance_record){
        $one_attendance_record->leave_start_time = $request->leave_start_time;
        $one_attendance_record->leave_end_time = $request->leave_end_time;
        $one_attendance_record->leave_reason = $request->leave_reason;
        $one_attendance_record->mtb_leave_check_status_id = MtbLeaveCheckStatuse::APPROVAL_PENDING;
        $one_attendance_record->save();
      }

      $one_message = '欠勤の申請を送信しました。承認を得るまでしばらくお待ち下さい。';
      return redirect()->back()->with(['one_message' => $one_message]);

    }

    
}
