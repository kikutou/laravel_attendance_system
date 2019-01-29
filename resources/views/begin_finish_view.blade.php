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

<div>
@php
setlocale(LC_ALL, 'ja_JP.UTF-8');
@endphp
{{ \Carbon\Carbon::today()->formatLocalized('%Y年%m月%d日(%a)') }}
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
@endif
