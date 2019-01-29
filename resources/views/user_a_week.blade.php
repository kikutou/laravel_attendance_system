<html>
  <head>
    <title>user_a_week</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- bootstrap  -->
    <!-- 新 Bootstrap4 核心 CSS 文件 -->
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/4.1.0/css/bootstrap.min.css">
    <!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
    <script src="https://cdn.staticfile.org/jquery/3.2.1/jquery.min.js"></script>
    <!-- popper.min.js 用于弹窗、提示、下拉菜单 -->
    <script src="https://cdn.staticfile.org/popper.js/1.12.5/umd/popper.min.js"></script>
    <!-- 最新的 Bootstrap4 核心 JavaScript 文件 -->
    <script src="https://cdn.staticfile.org/twitter-bootstrap/4.1.0/js/bootstrap.min.js"></script>

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
    </style>
  </head>
  <body>
    <h3>一週間の勤怠表</h3>
    @foreach($attendance_records as $attendance_record)
    <div class="row">
      <div class="col-sm-8"></div>
      <div class="col-sm-4 top1">名前:{{ $attendance_record->users->name }}</div>
    </div>
    <div id="cools"class="row">
      <table>
        <tr>
          <th></th>
          <th>日付</th>
          <th>出勤時間</th>
          <th>退勤時間</th>
        </tr>
        <tr>
          <td>
            @if(date("w",strtotime($attendance_record->attendance_date)) == 1)
            月曜日
            @elseif(date("w",strtotime($attendance_record->attendance_date)) == 2)
            火曜日
            @elseif(date("w",strtotime($attendance_record->attendance_date)) == 3)
            水曜日
            @elseif(date("w",strtotime($attendance_record->attendance_date)) == 4)
            木曜日
            @elseif(date("w",strtotime($attendance_record->attendance_date)) == 5)
            金曜日
            @elseif(date("w",strtotime($attendance_record->attendance_date)) == 6)
            土曜日
            @elseif(date("w",strtotime($attendance_record->attendance_date)) == 0)
            日曜日
            @endif
          </td>
          <td>{{ $attendance_record->attendance_date->format("Y年n月j日") }}</td>
          <td>{{ $attendance_record->start_time }}</td>
          <td>{{ $attendance_record->end_time }}</td>
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
          <td id="cool">{{ $attendance_record->leave_start_time }}</td>
          <td id="cool">{{ $attendance_record->leave_end_time }}</td>
          <td id="cool">{{ $attendance_record->leave_reason }}</td>
          <td id="cool">
            @if ($attendance_record->mtb_leave_check_status_id == 1)
            承認待ち
            @elseif ($attendance_record->mtb_leave_check_status_id == 2)
            承認済
            @elseif ($attendance_record->mtb_leave_check_status_id == 3)
            断り
            @endif
          </td>
          <td id="cool">{{ $attendance_record->leave_applicate_time }}</td>
          <td id="cool">{{ $attendance_record->leave_check_time }}</td>
        </tr>
      </table>
    </div>
    @endforeach
  </body>
</html>
