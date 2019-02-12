@extends('layouts.app')
@section('title','勤怠管理')
@section('content')
<script>
$(function(){　 //現在時刻の表示
  setInterval(function(){
    var now = new Date();
    var y = now.getFullYear();
    var m = now.getMonth() + 1;
    var d = now.getDate();
    var w = now.getDay();
    var h = now.getHours();
    var min = now.getMinutes();
    var s = now.getSeconds();
    var wNames = ['日', '月', '火', '水', '木', '金', '土'];

    if (m < 10) {
      m = '0' + m;
    }
    if (d < 10) {
      d = '0' + d;
    }
    if (h < 10) {
      h = '0' + h;
    }
    if (min < 10) {
      min = '0' + min;
    }
    if (s < 10) {
      s = '0' + s;
    }

    $('#time_now').text(y + '年' + m + '月' + d + '日 (' + wNames[w] + ')' + ' ' + h + ':'　+ min + ':'　+ s);
  }, 1000);
});
</script>

<div class="container">
  <div class="row justify-content-center">
      <div class="col-md-8">
          <div class="card">
              <div class="card-header">勤怠管理</div>
              <div class="card-body">
                  <ul class="list-group">
                      <li class="list-group-item" style="text-align:center;border:0px" ><span class="person-info-title">出勤標準時間&nbsp</span>{{ $time_lim->format('H:i') }}</li>
                      <li id='time_now' class="list-group-item" style="text-align:center;border:0px">現在時間取得中</li>
                       <form action="{{ route('attendance_begin_finish') }}" method="post">
                          @csrf
                          <div>
                            <input type="hidden" name="attendance_date" value="{{ $attendance_date }}">
                          </div>

                          @if(!$rec || !$rec->start_time)  {{--出勤記録がない場合--}}
                            @if(\Carbon\Carbon::now()->gt($time_lim))　{{--遅刻する場合--}}
                              <li class="list-group-item" style="border:0px"><span class="person-info-title">遅刻原因</span>
                                <textarea id="late" name="reason" class="form-control" rows="2" style="width:100%"></textarea>
                              </li>
                            @endif
                              <li class="list-group-item" style="text-align:center;border:0px"><input type="submit" class="btn btn-primary" name="begin" value="出勤"></li>
                          @elseif($rec && $rec->start_time && !$rec->end_time)　{{--出勤記録があり、退勤記録がない場合--}}
                              <li class="list-group-item" style="border:0px"><span class="person-info-title">勤務報告
                                <textarea id="late" name="report" class="form-control" rows="2" style="width:100%"></textarea>
                              </li>
                              <li class="list-group-item" style="text-align:center;border:0px"><input type="submit" name="begin" class="btn btn-primary" value="退勤"></li>
                          @endif
                          @if ($rec && $rec->start_time)
                          <li id='time_start' class="list-group-item" style="text-align:center;border:0px">今日の出勤時間&nbsp{{ $rec->start_time }}</li>
                          @endif
                          @if ($rec && $rec->end_time)
                          <li id='time_end' class="list-group-item" style="text-align:center;border:0px">今日の退勤時間&nbsp{{ $rec->end_time }}</li>
                          @endif
                      </form>
                  </ul>
              </div>
          </div>
      </div>
  </div>
</div>
@endsection
