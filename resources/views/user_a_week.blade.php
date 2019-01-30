@extends("layouts.app")

@section("content")
  <style>
    table {
      margin-left:200px;
      margin-right: 200px;
      border-collapse: collapse;
      border-spacing: 0;
      width: 100%;
      border: 2px solid #ddd;
    }
    th,td {
      border: none;
      text-align: center;
      padding: 8px;
      height:50px;
    }
    tr:nth-child(even){background-color: #f2f2f2}
    h3{
      text-align: center;
      margin-top:100px;
    }
    #cool{
      width: 100px;
    }
    #cools{
      margin-top: 30px;
    }
    .top1{
      padding-top: 20px;
    }
    .top{
      margin-top: 20px;
    }
  </style>
    <h3>一週間の勤怠表</h3>
    <div class="row">
      <div class="col-sm-8"></div>
      <div class="col-sm-4 top1">名前:{{ Auth::user()->name }}</div>
    </div>
    <div id="cools"class="row">
      @for ($i=6; $i>=0; $i--)
        @php
        $this_date = \Carbon\Carbon::today()->subDay($i);
        $show_record = null;
        @endphp
        <table class="top table table-striped">
          <tr>
            <th>日付</th>
            <th>出勤時間</th>
            <th>退勤時間</th>
          </tr>
          <tr>
            @foreach ($attendance_records as $attendance_record)
                @if ($attendance_record->attendance_date == $this_date)
                  @php
                    $show_record = $attendance_record;
                  @endphp
                  @break
                @endif
            @endforeach

<<<<<<< HEAD
        </tr>
      </table>
      <table>
        <tr>
          <th>欠勤開始時間</th>
          <th>欠勤終了時間</th>
          <th>欠勤理由</th>
          <th>欠勤承認状態</th>
          <th>欠勤申請時間</th>
          <th>承認時間</th>
        </tr>
        <tr>
          <td id="cool">{{ $show_record->leave_start_time ??"出勤していません。" }}</td>
          <td id="cool">{{ $show_record->leave_end_time ??"出勤していません。" }}</td>
          <td id="cool">{{ $show_record->leave_reason ??"出勤していません。" }}</td>
          <td id="cool">
            @if ($show_record['mtb_leave_check_status_id'] == 1)
            承認待ち
            @elseif ($show_record['mtb_leave_check_status_id'] == 2)
            承認済
            @elseif ($show_record['mtb_leave_check_status_id'] == 3)
            断り
            @elseif(!$show_record['mtb_leave_check_status_id'])
            出勤していません。
            @endif
          </td>
          <td id="cool">{{ $show_record->leave_applicate_time??"出勤していません。" }}</td>
          <td id="cool">{{ $show_record->leave_check_time??"出勤していません。" }}</td>
        </tr>
      </table>
=======
            @if ($show_record)
              <td>{{ $show_record->attendance_date->format('Y年n月j日') }}</td>
              <td>{{ $show_record->start_time }}</td>
              <td>{{ $show_record->end_time }}</td>
            @else
              <td>{{ $this_date->format('Y年n月j日') }}</td>
              <td>出勤していません。</td>
              <td>出勤していません。</td>
            @endif

          </tr>
        </table>

        @if($show_record && $show_record->leave_start_time)
        <table>
          <tr>
            <th>欠勤開始時間</th>
            <th>欠勤終了時間</th>
            <th>欠勤理由</th>
            <th>欠勤承認状態</th>
            <th>欠勤申請時間</th>
            <th>承認時間</th>
          </tr>
          <tr>
            <td id="cool">{{ $show_record->leave_start_time ??"出勤していません。" }}</td>
            <td id="cool">{{ $show_record->leave_end_time ??"出勤していません。" }}</td>
            <td id="cool">{{ $show_record->leave_reason ??"出勤していません。" }}</td>
            <td id="cool">
              @if ($show_record && $show_record->mtb_leave_check_status_id == 1)
              承認待ち
              @elseif ($show_record && $show_record->mtb_leave_check_status_id == 2)
              承認済
              @elseif ($show_record && $show_record->mtb_leave_check_status_id == 3)
              断り
              @elseif(!$show_record || !$show_record->mtb_leave_check_status_id)
              出勤していません。
              @endif
            </td>
            <td id="cool">{{ $show_record->leave_applicate_time??"出勤していません。" }}</td>
            <td id="cool">{{ $show_record->leave_check_time??"出勤していません。" }}</td>
          </tr>
        </table>
        @endif
>>>>>>> ce636e963f521b09c5188a3d65b9cafc3489cf78

      @endfor
    </div>
@endsection
