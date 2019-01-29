@extends('layouts.layout')

@section('content')

<div class="row">
  <div class="col-sm-3"></div>

  <div class="col-sm-6">
    <div class="row text-center">
      <div class="col-sm">
      <p>{{ \Carbon\Carbon::today()->format('Y年m月d日') }}
        @if(\Carbon\Carbon::today()->dayOfWeek == 1)
        (月)
        @elseif(\Carbon\Carbon::today()->dayOfWeek == 2)
        (火)
        @elseif(\Carbon\Carbon::today()->dayOfWeek == 3)
        (水)
        @elseif(\Carbon\Carbon::today()->dayOfWeek == 4)
        (木)
        @elseif(\Carbon\Carbon::today()->dayOfWeek == 5)
        (金)
        @elseif(\Carbon\Carbon::today()->dayOfWeek == 6)
        (土)
        @elseif(\Carbon\Carbon::today()->dayOfWeek == 0)
        (日)
        @endif
      </p>
      </div>
    </div>

    @if($errors->any())
    <div class="row text-center">
      <div class="col-sm">
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

      @if(!$rec1 || $rec2)
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

      @elseif(!$rec2 && $rec3)
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

    @if($rec1 && !$rec2)
    <div class="row text-center">
      <div class="col-sm">
        <p>出勤時間　{{ $rec1->start_time }}</p>
      </div>
    </div>
    @endif
    @if ($rec1 && !$rec3)
    <div class="row text-center">
      <div class="col-sm">
        <p>退勤時間　{{ $rec1->end_time }}</p>
      </div>
    </div>
    @endif
  </div>

  <div class="col-sm-3"></div>

</div>

@endsection

<!-- <div>
@php
setlocale(LC_ALL, 'ja_JP.UTF-8');
@endphp
{{ \Carbon\Carbon::today()->formatLocalized('%Y年%m月%d日(%a)') }}
</div>

@if (Session::has('message'))
<div>
  {{ Session::get('message') }}
</div>
@endif

@if ($errors->any())
<div>
  <ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif

<div>
  <form action="{{ route('attendance_begin_finish') }}" method="post">
    @csrf
    <input type="hidden" name="attendance_date" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
    @if(!$rec2 && $rec3)
    勤務報告<textarea type="text" name="report"></textarea>
    <input type="submit" name="finish" value="退勤">
    @elseif(!$rec1 || $rec2)
    @if(\Carbon\Carbon::now()->gt($time_lim))
    遅刻原因<textarea type="text" name="reason"></textarea>
    @endif
    <input type="submit" name="begin" value="出勤">
    @else
    @endif
  </form>
</div>

@if($rec1 && !$rec2)
<div>
出勤時間：{{ $rec1->start_time }}
</div>
@endif
@if($rec1 && !$rec3)
<div>
退勤時間：{{ $rec1->end_time }}
</div>
@endif -->
