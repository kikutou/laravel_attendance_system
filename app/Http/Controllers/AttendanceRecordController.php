<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\AttendanceRecord;
use Carbon\Carbon;
use App\Model\Master\MtbLeaveCheckStatus;
use App\User;
use Validator;
use Response;
use Illuminate\Support\Facades\Auth;


class AttendanceRecordController extends Controller
{
  public function begin_finish_view() {
    //出退席画面にアクセスする
    $user_id = Auth::id();
    //ユーザーのidを取得する
    $user_rec = AttendanceRecord::query()->where('user_id', $user_id)->where('attendance_date', Carbon::now()->format('Y-m-d'))->first();
    //本日ユーザーの出退席状態を確認する
    $time_lim = new Carbon(env('START_TIME',"09:00:00"));
    //標準出席時間を設定する
    return view('begin_finish_view', ['rec' => $user_rec, 'time_lim' => $time_lim, 'attendance_date' => Carbon::now()->format('Y-m-d')]);
    //出退席データ・出席標準時間・現在日の日付をVIEWに渡す
  }

  public function attendance_begin_finish(Request $request) {
    //出退席機能
    if ($request->attendance_date == Carbon::now()->format('Y-m-d')) {
    //出席日と現在日を確認する
        $user_rec = AttendanceRecord::query()->where('user_id', Auth::id())->where('attendance_date', Carbon::now()->format('Y-m-d'))->first();
        //本日ユーザーの出退席状態を確認する、データが存在する場合は、記録を取得する
        $time_lim = new Carbon(env('START_TIME', '09:00:00'));
        //標準出席時間を設定する

        if (!$user_rec)
        //出席1：出席・休み記録がない場合
        {
          $user_rec = New AttendanceRecord;
          //新しいデータを作る
          $user_rec->user_id = Auth::id();
          //ユーザーIDを設定する
          $user_rec->attendance_date = Carbon::now()->format('Y-m-d');
          //日付を設定する
          $user_rec->start_time = Carbon::now()->format('H:i');
          //出席時間を設定する

          if (Carbon::now()->gt($time_lim))
          //遅刻する場合
          {
            $validator_rules = [
              'reason' => 'required'
              //遅刻原因の説明が必要である
            ];
            $validator_messages = [
              'reason.required' => '遅刻原因を説明してください。'
            ];
            $validator = Validator::make($request->all(), $validator_rules, $validator_messages);
            //バリエーションを設置する

            if ($validator->fails())
            {
              return redirect()->back()->withInput()->withErrors($validator);
              //入力しないと、エラーメッセージを付けて、前の画面にリダイレクトする
            }
            $user_rec->reason = $request->reason;
            //入力原因を設定する
          }
          $user_rec->save();
          //出席記録を保存する
          $message = '操作成功。';
          return redirect()->back()->with(['message' => $message]);
          //成功メッセージを付けて、前の画面にリダイレクトする
        }

        if ($user_rec && !$user_rec->start_time) {
          //出席2：休み記録があるが、出席時間がない場合

            $user_rec->start_time = Carbon::now()->format('H:i');
            //出席時間を設定する
            if (Carbon::now()->gt($time_lim))
            //遅刻する場合
            {
              $validator_rules = [
                'reason' => 'required'
                //遅刻原因の説明が必要である
              ];
              $validator_messages = [
                'reason.required' => '遅刻原因を説明してください。'
              ];
              $validator = Validator::make($request->all(), $validator_rules, $validator_messages);
              //バリエーションを設置する

              if ($validator->fails())
              {
                return redirect()->back()->withInput()->withErrors($validator);
                //入力しないと、エラーメッセージを付けて、前の画面にリダイレクトする
              }
              $user_rec->reason = $request->reason;
              //入力原因を設定する
            }
            $user_rec->save();
            //出席記録を保存する
            $message = '操作成功。';
            return redirect()->back()->with(['message' => $message]);
            //成功メッセージを付けて、前の画面にリダイレクトする
          }

          if ($user_rec->start_time && !$user_rec->end_time) {
          //退席：出席記録があり、退席記録がない場合
            $validator_rules = [
              'report' => 'required'
              //勤務レポートの提出が必要である
            ];
            $validator_messages = [
              'report.required' => '今日のレポートを提出してください。'
            ];
            $validator = Validator::make($request->all(), $validator_rules, $validator_messages);
            //バリエーションを設置する
            if ($validator->fails())
            {
              return redirect()->back()->withInput()->withErrors($validator);
              //入力しないと、エラーメッセージを付けて、前の画面にリダイレクトする
            }
            $user_rec->end_time = Carbon::now()->format('H:i');
            //退席時間を設定する
            $user_rec->report = $request->report;
            //レポートを設定する
            $user_rec->save();
            //退席記録を保存する
            $message = '操作成功。今日はお疲れ様でした。';
            return redirect()->back()->with(['message' => $message]);
            //成功メッセージを付けて、前の画面にリダイレクトする
          }
        }

      $error = '操作を完了できませんでした。管理者に連絡してください。';
      return redirect()->back()->with(['error' => $error]);
      //出席日と現在日が異なる場合、エラーメッセージを付けて、前の画面にリダイレクトする
    }


  /**
   *
   *欠勤申請画面の表示。
   *
   */
  public function create(Request $request)
  {
    return view('leave_request');
  }

  /**
   *
   *欠勤申請機能。
   *
   */
  public function store(Request $request)
  {
    $validator = Validator::make($request->all(),AttendanceRecord::$validator_rules,AttendanceRecord::$validator_messages);
    if($validator->fails()){
      return redirect()->back()->withInput()->withErrors($validator);
    }

    //日付が過去かどうかを確認する。
    $carbon = new Carbon($request->attendance_date);
    if($carbon->lt(Carbon::today())){
      $one_message = "本日以降の日付をお選びください。";
      return redirect()->back()->withInput()->with(['error' => $one_message]);
    }

    //出席時間外での申請制御。
    $user = Auth::user();
    $leave_start_time = $request->leave_start_hour.":".$request->leave_start_minute;
    $leave_end_time = $request->leave_end_hour.":".$request->leave_end_minute;
    if(!AttendanceRecord::check_leave_time($user, $request->attendance_date,  $leave_start_time,  $leave_end_time)) {
      $one_message = "出席時間外の時間で申請してください!";
      return redirect()->back()->with(['error' => $one_message]);
    }

    //欠勤申請データの書き込み。
    $one_attendance_record = AttendanceRecord::where('user_id', $user->id)
      ->where('attendance_date',$request->attendance_date ?? Carbon::today())
      ->first();

    if(!$one_attendance_record){
      $one_attendance_record = new AttendanceRecord;
      $one_attendance_record->user_id = $user->id;
      $one_attendance_record->attendance_date = $request->attendance_date ? Carbon::createFromFormat("Y/m/d", $request->attendance_date) : Carbon::today();


    }

    $one_attendance_record->leave_start_time =  $leave_start_time;
    $one_attendance_record->leave_end_time =  $leave_end_time;
    $one_attendance_record->leave_reason = $request->leave_reason;
    $one_attendance_record->leave_applicate_time = Carbon::now();
    $one_attendance_record->mtb_leave_check_status_id = MtbLeaveCheckStatus::APPROVAL_PENDING;
    $one_attendance_record->save();

    $one_message = "欠勤の申請を送信しました。承認を得るまでしばらくお待ち下さい。";
    return redirect(route('home'))->with(['message' => $one_message]);

  }

    /**
     * 会員の一週間の出席常置を表示する
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
  public function get_all(Request $request)
  {
    $today = Carbon::now();
    $attendance_records = AttendanceRecord::where('user_id', Auth::id())
      ->where('attendance_date', '<=' , Carbon::today()->format('Y-m-d'))
      ->where('attendance_date', '>', Carbon::today()->subWeek(1)->format('Y-m-d'))
      ->get();
    return view('user_a_week',[
      'attendance_records'=>$attendance_records,
      'today' => $today
    ]);
  }


  public function user_find(Request $request)
  {
    $user = User::whereNotNull('email_verified_at')->get();
    $attendance_records = null;
    $users = User::all();

    if($request->search) {
      if($request->user_id == "all") {
        $users_rec = User::all();
        $attendance_records = AttendanceRecord::query();
      } else {
        $users_rec = array();
        $users_rec[] = User::find($request->user_id);
        $attendance_records = AttendanceRecord::query()->where('user_id', $request->user_id);
      }

      if($request->start) {
        $starttime = New Carbon($request->start);
        if($starttime > Today()){
           $error = '【開始日】今日以前の日付を入力してください。';
           return  redirect()->back()->with(['error' => $error]);
        }
      } else {
        $first_record = AttendanceRecord::orderBy('attendance_date','asc')->first();

      if($first_record) {
        $starttime = New Carbon($first_record->attendance_date);
        } else {
        $error = 'データが存在しません。';
        return  redirect()->back()->with(['error' => $error]);
        }

      }

      if ($starttime > New Carbon($request->end)){
         $error = '【開始日】終了日以前の日付を入力してください。';
         return  redirect()->back()->with(['error' => $error]);
      }

      $attendance_records = $attendance_records->where('attendance_date', '>=', $starttime);

      if($request->end && new Carbon($request->end) <= Today()) {
        $endtime = New Carbon($request->end);
      } else {
        $endtime = Today();
      }

      $attendance_records = $attendance_records->where('attendance_date', '<=', $endtime);

      $diff = $starttime->diffIndays($endtime) + 1;

      return view ('admin.user_find', [
        'attendance_records' => $attendance_records,
        'users' => $users,
        'users_rec' => $users_rec,
        'starttime' => $starttime,
        'endtime' => $endtime,
        'diff' => $diff
      ]);
    }

    return view ('admin.user_find', [
      'attendance_records' => $attendance_records,
      'users' => $users]);
  }

    public function create_csv()
    {
      $recs_r = AttendanceRecord::where('user_id', '=', Auth::id())->where('attendance_date', '>=', Carbon::today()->firstOfMonth())->where('attendance_date', '<=', Carbon::today()->endOfMonth())->get(['attendance_date', 'start_time', 'end_time', 'leave_start_time', 'leave_end_time'])->toArray();
      $recs = [];
      $rec_n = [];
      $time_count = null;

      for ($i = 0; $i < Carbon::today()->daysInMonth; $i++) {
        $thisday = Carbon::today()->firstOfMonth()->addDays($i);

        foreach ($recs_r as $rec_r) {
          if ($rec_r['attendance_date'] == $thisday) {
            $rec_n = $rec_r;
            break;
          }
        }

        if ($rec_n) {
          $rec_n['attendance_date'] = date('Y-m-d', strtotime($thisday));
          if ($rec_n['end_time']) {
            $time_start = new Carbon($rec_n['start_time']);
            $time_end = new Carbon($rec_n['end_time']);
            $time_oneday = $time_end->diffInMinutes($time_start);
            $time_count = $time_count + $time_oneday;
          }

          if ($rec_n['leave_end_time']) {
            $rec_n['leave_start_time'] = '休み' . $rec_n['leave_start_time'] . '-' . $rec_n['leave_end_time'];
            $rec_n['leave_end_time'] = null;
          }

          $recs[] = $rec_n;
        }

        else {
          $rec_n['attendance_date'] = date('Y-m-d', strtotime($thisday));
          $recs[] = $rec_n;
        }

        $rec_n = [];
      }

      $csvHeader = ['日付', '出席時間', '退席時間'];
      array_unshift($recs, $csvHeader);

      $time_count_hour = floor($time_count / 60);
      $time_count_min = $time_count % 60;

      $csvFooter = ['本月の総出席時間', $time_count_hour . '時間' . $time_count_min . '分', '', 'サイン', ''];
      array_push($recs, $csvFooter);

      $stream = fopen('php://temp', 'r+b');
      foreach ($recs as $rec) {
        fputcsv($stream, $rec);
      }
      rewind($stream);
      $csv = str_replace(PHP_EOL, "\r\n", stream_get_contents($stream));
      $csv = mb_convert_encoding($csv, 'SJIS-win', 'UTF-8');
      $filename = date('YmdHis') . '.' . 'csv';
      $headers = array(
        'Content-Type' => 'text/csv',
        'Content-Disposition' => "attachment; filename=$filename",
      );
      return Response::make($csv, 200, $headers);
    }



    public function create_csv_find(Request $request)
    {
      $starttime =  New Carbon($request->starttime['date']);
      //開始日を取得する
      $endtime = New Carbon($request->endtime['date']);
      //終了日を取得する
      $diff = $starttime->diffIndays($endtime);
      //日付の差を計算する

      $recs_r = AttendanceRecord::where('user_id', '=', $request->user_id)->where('attendance_date', '>=', $starttime)->where('attendance_date', '<=', $endtime)->get(['attendance_date', 'start_time', 'end_time', 'leave_start_time', 'leave_end_time'])->toArray();
      //時間範囲内のデータを取得し、配列に入れる
      $recs = [];
      $rec_n = [];
      $time_count = null;

      for ($i = 0; $i <= $diff; $i++) {
        $start_at = clone $starttime;
        $thisday = $start_at->addDays($i);
        //for文で開始日から終了日までのデータを構成する

        foreach ($recs_r as $rec_r) {
          if ($rec_r['attendance_date'] == $thisday) {
            //出席または休み記録がある日であれば
            $rec_n = $rec_r;
            break;
          }
        }

        if ($rec_n) {
          $rec_n['attendance_date'] = date('Y-m-d', strtotime($thisday));
          //日付の形式を整理する
          if ($rec_n['end_time']) {
            $time_start = new Carbon($rec_n['start_time']);
            $time_end = new Carbon($rec_n['end_time']);
            $time_oneday = $time_end->diffInMinutes($time_start);
            $time_count = $time_count + $time_oneday;
            //出席総時間を分で計算する
          }

          if ($rec_n['leave_end_time']) {
            $rec_n['leave_start_time'] = '休み' . $rec_n['leave_start_time'] . '-' . $rec_n['leave_end_time'];
            $rec_n['leave_end_time'] = null;
            //休み記録があれば、開始時間と終了時間を記入する
          }

          $recs[] = $rec_n;
          //データを配列に入れる
        }

        else {
          $rec_n['attendance_date'] = date('Y-m-d', strtotime($thisday));
          $recs[] = $rec_n;
        }

        $rec_n = [];
      }

        $csvHeader = ['日付', '出席時間', '退席時間'];
      array_unshift($recs, $csvHeader);
      //各項目のタイトルを表の先頭に入れる

      $csvHeader_b = ['名前', User::find($request->user_id)->name];
      array_unshift($recs, $csvHeader_b);
      //個人情報を表の先頭に入れる

      $time_count_hour = floor($time_count / 60);
      //出席総時間の時間数を取得する
      $time_count_min = $time_count % 60;
      //余る分の数を取得する

      $csvFooter = ['総出席時間', $time_count_hour . '時間' . $time_count_min . '分', '', 'サイン', ''];
      array_push($recs, $csvFooter);
      //最後に総出席時間を表示する

      $stream = fopen('php://temp', 'r+b');
      foreach ($recs as $rec) {
        fputcsv($stream, $rec);
        //配列の各項目をcvsファイルに保存する
      }
      rewind($stream);
      $csv = str_replace(PHP_EOL, "\r\n", stream_get_contents($stream));
      $csv = mb_convert_encoding($csv, 'SJIS-win', 'UTF-8');
      $filename = date('YmdHis') . '.' . 'csv';
      //ファイルの命名規則を指定する
      $headers = array(
        'Content-Type' => 'text/csv',
        'Content-Disposition' => "attachment; filename=$filename",
      );
      return Response::make($csv, 200, $headers);
      //csvファイルを出力する
    }
}
