@extends('layouts.layout')


@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<div class="row">
  <div class="col-sm-3"></div>

  <div class="col-sm-6">
    <div class="row text-center">
      <div class="col-sm">
        <p id='time_now'>現在時間取得中</p>
      </div>
    </div>

    <div class="row text-center">
      <div class="col-sm">
        <p>出勤標準時間　{{ $time_lim->format('H:i:s') }}</p>
      </div>
    </div>

    @if($errors->any())
    <div class="row text-center">
      <div class="col-sm text-danger">
          @foreach ($errors->all() as $error)
          <p>{{ $error }}</p>
          @endforeach
      </div>
    </div>
    @endif

    @if (Session::has('message'))
    <div class="row text-center">
      <div class="col-sm">
        <p>{{ Session::get('message') }}</p>
      </div>
    </div>
    @endif

    <form action="{{ route('attendance_begin_finish') }}" method="post">
      @csrf
      <div>
        <input type="hidden" name="attendance_date" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
      </div>

      @if(!$rec || !$rec->start_time)
        @if(\Carbon\Carbon::now()->gt($time_lim))
        <div class="row text-center">
          <div class="col-sm-4">
            <p>遅刻原因</p>
          </div>
          <div class="col-sm-8">
            <textarea type="text" name="reason"></textarea>
          </div>
        </div>
        @endif

      <div class="row text-center">
        <div class='col-sm'>
          <input type="submit" name="begin" value="出勤">
        </div>
      </div>

      @elseif($rec && $rec->start_time && !$rec->end_time)
      <div class="row text-center">
        <div class="col-sm-4">
          <p>勤務報告</p>
        </div>
        <div class="col-sm-8">
          <textarea type="text" name="report"></textarea>
        </div>
      </div>

      <div class="row text-center">
        <div class='col-sm'>
          <input type="submit" name="begin" value="退勤">
        </div>
      </div>
      @endif

  </form>

    @if($rec && $rec->start_time)
    <div class="row text-center">
      <div class="col-sm">
        <p>出勤時間　{{ $rec->start_time }}</p>
      </div>
    </div>
    @endif
    @if ($rec && $rec->end_time)
    <div class="row text-center">
      <div class="col-sm">
        <p>退勤時間　{{ $rec->end_time }}</p>
      </div>
    </div>
    @endif
  </div>

  <div class="col-sm-3"></div>

</div>

<script>
$(function(){
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

    $('#time_now').text(y + '年' + m + '月' + d + '日 (' + wNames[w] + ')' + '　' + h + ':'　+ min + ':'　+ s);
  }, 1000);
});
</script>

@endsection
