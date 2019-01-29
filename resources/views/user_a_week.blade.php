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

    <div class="row">
      <div class="col-sm-8"></div>
      <div class="col-sm-4 top1">名前:</div>
    </div>
    <div id="cools"class="row">
      @for($i=6; $i>=0; $i--)
        @php
        $this_date = \Carbon\Carbon::today()->subDay($i);
        $show_record = null;
        @endphp
      @foreach($attendance_records as $attendance_record)

            @if($attendance_record->attendance_date == $this_date)
              @php
                $show_record = $this_date;
              @endphp
              @break
            @endif
            @if($show_record)
            <table>
              <tr>
                <th></th>
                <th>日付</th>
                <th>出勤時間</th>
                <th>退勤時間</th>
              </tr>
              <tr>
                <td>
                </td>
                <td>{{ $attendance_record->attendance_date->format("Y年n月j日") }}</td>
                <td>{{ $attendance_record->start_time }}</td>
                <td>{{ $attendance_record->end_time }}</td>
              </tr>
            </table>

    </div>
  </body>
</html>
