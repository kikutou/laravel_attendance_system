<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\AttendanceRecord;
use Carbon\Carbon;
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

      if (!$user_rec)
      {
        $user_rec = New AttendanceRecord;
        $user_rec->user_id = 1;
        $user_rec->attendance_date = Carbon::now()->format('Y-m-d');
        $user_rec->start_time = Carbon::now()->format('H:i');

        if ($request->reason)
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

      if ($user_rec){
        if (!$user_rec->start_time)
        {
          $user_rec->start_time = Carbon::now()->format('H:i');

          if ($request->reason)
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

  // public function attendance_begin_finish(Request $request) {
  //   if ($request->attendance_date == Carbon::now()->format('Y-m-d'))
  //   {
  //     $user_rec = AttendanceRecord::query()->where('user_id', auth('user')->user()->id)->where('attendance_date', Carbon::now()->format('Y-m-d'))->first();
  //
  //     if (!$user_rec)
  //     {
  //       $user = New AttendanceRecord;
  //       $user->user_id = auth('user')->user()->id;
  //       $user->attendance_date = Carbon::now()->format('Y-m-d');
  //       $user->start_time = Carbon::now()->format('H:i');
  //       $user->save();
  //
  //       $message = '操作成功。';
  //       return redirect()->back()->with($message);
  //     }
  //
  //     if ($user_rec){
  //       if (!$user_rec->start_time)
  //       {
  //         $user = $user_rec;
  //         $user->start_time = Carbon::now()->format('H:i');
  //         $user->save();
  //
  //         $message = '操作成功。';
  //         return redirect()->back()->with($message);
  //       }
  //
  //       if ($user_rec->start_time && !$user_rec->end_time)
  //       {
  //         $user = $user_rec;
  //         $user->end_time = Carbon::now()->format('H:i');
  //         $user->save();
  //
  //         $message = '操作成功。今日はお疲れ様でした。';
  //         return redirect()->back()->with($message);
  //       }
  //
  //       $message = '操作を完了できませんでした。管理者に連絡してください。';
  //       return redirect()->back()->with($message);
  //     }
  //
  //     $message = '操作を完了できませんでした。管理者に連絡してください。';
  //     return redirect()->back()->with($message);
  //   }
  //
  //   $message = '操作を完了できませんでした。管理者に連絡してください。';
  //   return redirect()->back()->with($message);
  // }


 }
