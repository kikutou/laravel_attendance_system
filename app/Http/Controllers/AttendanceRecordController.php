<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\AttendanceRecord;
use Carbon\Carbon;
use App\Model\Master\MtbLeaveCheckStatuse;
use App\Model\User;
use Validator;

class AttendanceRecordController extends Controller
{
  public function begin_finish_view() {
    $user_rec1 = AttendanceRecord::query()->where('user_id', 1)->where('attendance_date', Carbon::now()->format('Y-m-d'))->first();
    $user_rec2 = AttendanceRecord::query()->where('user_id', 1)->where('attendance_date', Carbon::now()->format('Y-m-d'))->where('start_time', null)->first();
    $user_rec3 = AttendanceRecord::query()->where('user_id', 1)->where('attendance_date', Carbon::now()->format('Y-m-d'))->where('end_time', null)->first();

    $time_lim = new Carbon('09:00:00');
    return view('begin_finish_view', ['rec1' => $user_rec1, 'rec2' => $user_rec2, 'rec3' => $user_rec3, 'time_lim' => $time_lim]);
  }

  public function attendance_begin_finish(Request $request) {
    if ($request->attendance_date == Carbon::now()->format('Y-m-d'))
    {
      $user_rec = AttendanceRecord::query()->where('user_id', 1)->where('attendance_date', Carbon::now()->format('Y-m-d'))->first();
      $time_lim = new Carbon('09:00:00');

      if (!$user_rec)
      {
        $user_rec = New AttendanceRecord;
        $user_rec->user_id = 1;
        $user_rec->attendance_date = Carbon::now()->format('Y-m-d');
        $user_rec->start_time = Carbon::now()->format('H:i');

        if (Carbon::now()->gt($time_lim))
        {
          $validator_rules = [
            'reason' => 'required'
          ];

          $validator_messages = [
            'reason.required' => '遅刻原因を説明してください。'
          ];

          $validator = Validator::make($request->all(), $validator_rules, $validator_messages);

          if ($validator->fails())
          {
            return redirect()->back()->withInput()->withErrors($validator);
          }

          $user_rec->reason = $request->reason;
        }

        $user_rec->save();

        $message = '操作成功。';
        return redirect()->back()->with(['message' => $message]);

      }

      if ($user_rec) {
        if (!$user_rec->start_time)
        {
          $user_rec->start_time = Carbon::now()->format('H:i');

          if (Carbon::now()->gt($time_lim))
          {
            $validator_rules = [
              'reason' => 'required'
            ];

            $validator_messages = [
              'reason.required' => '遅刻理由を入力してください。'
            ];

            $validator = Validator::make($request->all(), $validator_rules, $validator_messages);

            if ($validator->fails())
            {
              return redirect()->back()->withInput()->withErrors($validator);
            }

            $user_rec->reason = $request->reason;
          }

          $user_rec->save();

          $message = '操作成功。';
          return redirect()->back()->with(['message' => $message]);
        }

        if ($user_rec->start_time && !$user_rec->end_time)
        {
          $validator_rules = [
            'report' => 'required'
          ];

          $validator_messages = [
            'report.required' => '今日のレポートを提出してください。'
          ];

          $validator = Validator::make($request->all(), $validator_rules, $validator_messages);

          if ($validator->fails())
          {
            return redirect()->back()->withInput()->withErrors($validator);
          }

          $user_rec->end_time = Carbon::now()->format('H:i');
          $user_rec->report = $request->report;
          $user_rec->save();

          $message = '操作成功。今日はお疲れ様でした。';
          return redirect()->back()->with(['message' => $message]);
        }

        $message = '操作を完了できませんでした。管理者に連絡してください。';
        return redirect()->back()->with(['message' => $message]);
      }

      $message = '操作を完了できませんでした。管理者に連絡してください。';
      return redirect()->back()->with(['message' => $message]);
    }

    $message = '操作を完了できませんでした。管理者に連絡してください。';
    return redirect()->back()->with(['message' => $message]);
  }

  /*休暇申請画面の表示。*/
  public function create_leave_request(Request $request)
  {
    return view('leave_request');
  }
  /*休暇申請機能。*/
  public function store_leave_request(Request $request)
  {
    $validator = Validator::make($request->all(),AttendanceRecord::$validator_rules,AttendanceRecord::$validator_messages);

    if($validator->fails())
    {
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


    public function get_all(Request $request)
    {
      $attendance_records = AttendanceRecord::all();
      return view('user_a_week',['attendance_records'=>$attendance_records]);
    }


}
