@extends("layouts.app")
@section("title","休暇認証")
@section("content")
    <link rel="stylesheet" href="{{asset('/css/leavecheck.css')}}">

    <script type="text/javascript">
      function clear1()
      {
       if(confirm("承認をしますか？"))
       {
       return true;
     }else {
       return false;
     }
      }
      function clear2()
      {
       if(confirm("断りをしますか？"))
       {
       return true;
     }else{
       return false;
     }
      }
    </script>
  <body>
    <div id="content" class="container-fluid">
      <div class="col-sm text-center top36 bottom36">
        <p>休み請求一覧</p>
      </div>

    <div class="col-sm text-center top36 bottom36">

      <div class="media row top36 bottom36">
        <div class="col-sm-3"></div>

        <div class="card top2 col-sm-6">
          <div class="card-header row cool">
            <div class="col-sm-3 p-2 {{ ($current_page=='all') ? 'bg-info' : '' }}">
              <a href="/check" style="color:{{ ($current_page=='all') ? 'white' : '' }}">すべて</a>
            </div>
            <div class="col-sm-3 p-2 {{ ($current_page=='approval_pending') ? 'bg-info' : '' }}">
              <a href="/check/approval_pending" style="color:{{ ($current_page=='approval_pending') ? 'white' : '' }}">未承認</a>
            </div>
            <div class="col-sm-3 p-2 {{ ($current_page=='approval') ? 'bg-info' : '' }}">
              <a href="/check/approval" style="color:{{ ($current_page=='approval') ? 'white' : '' }}">承認済み</a>
            </div>
            <div class="col-sm-3 p-2 {{ ($current_page=='refuse') ? 'bg-info' : '' }}">
              <a href="/check/refuse" style="color:{{ ($current_page=='refuse') ? 'white' : '' }}">断り</a>
            </div>
          </div>

          <div class="card-body">
            @foreach($attendancerecords as $attendancerecord)
            <ul class="list-group top1" id="socool">
              <li class="list-group-item"><span class="person-info-title">従業員&nbsp:</span>&nbsp{{ $attendancerecord->users->name }}</li>
              <li class="list-group-item"><span class="person-info-title">欠勤開始時間&nbsp:</span>&nbsp{{ $attendancerecord->attendance_date->format("Y年n月j日") . $attendancerecord->leave_start_time }}</li>
              <li class="list-group-item"><span class="person-info-title">欠勤終了時間&nbsp:</span>&nbsp{{ $attendancerecord->attendance_date->format("Y年n月j日") . $attendancerecord->leave_end_time }}</li>
              <li class="list-group-item"><span class="person-info-title">休みの理由&nbsp:</span>&nbsp{{ $attendancerecord->leave_reason}}</li>
              <li class="list-group-item"><span class="person-info-title">欠勤承認状態&nbsp:</span>
                @if ($attendancerecord->mtb_leave_check_status_id == 3)
                断り
                @elseif ($attendancerecord->mtb_leave_check_status_id == 1)
                未承認
                @elseif ($attendancerecord->mtb_leave_check_status_id == 2)
                承認済み
                @endif
              </li>
              @if($attendancerecord->leave_check_time && $attendancerecord->mtb_leave_check_status_id == 2)
              <li class="list-group-item"><span class="person-info-title">承認時間&nbsp:</span>&nbsp{{ $attendancerecord->leave_check_time }}</li>
              @elseif($attendancerecord->leave_check_time && $attendancerecord->mtb_leave_check_status_id == 3)
              <li class="list-group-item"><span class="person-info-title">断り時間&nbsp:</span>&nbsp{{ $attendancerecord->leave_check_time }}</li>
              @endif
              @if ($attendancerecord->mtb_leave_check_status_id == 1)
              <li class="list-group-item">
                <div class="form-inline" style="width:200px;margin:0 auto">
                  <div class="col-sm-6 text-right">
                    <form action="{{ route('post_check') }}" method="post">
                      @csrf
                      <input type="hidden" name="mtb_leave_check_status_id" value="{{ $attendancerecord->mtb_leave_check_status_id }}">
                      <input type="hidden" name="act" value="agree">
                      <input type="hidden" name="id" value="{{ $attendancerecord->id }}">
                      <input onclick="return clear1()" type="submit" class="btn btn-primary" value="承認">
                    </form>
                  </div>
                  <div class="col-sm-6 text-left">
                    <form action="{{ route('post_check') }}" method="post">
                      @csrf
                      <input type="hidden" name="mtb_leave_check_status_id" value="{{ $attendancerecord->mtb_leave_check_status_id }}">
                      <input type="hidden" name="id" value="{{ $attendancerecord->id }}">
                      <input type="hidden" name="act" value="disagree">
                      <input onclick="return clear2()" type="submit" class="btn btn-primary" value="断る">
                    </form>
                  </div>
                </div>
              </li>
              @else
              @endif
            </ul>
            @endforeach
          </div>
        </div>
      <div class="col-sm-3"></div>
    </div>
   </div>
  </body>
@endsection
