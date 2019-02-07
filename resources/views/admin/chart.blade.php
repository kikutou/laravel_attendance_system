@extends('layouts.app')
@section('title','遅刻照会')
@section('content')

<div class="container">
    @if(Session::has('one_message'))
      <div style="width:500px;margin:0 auto">
        <h5>{{ Session::get('one_message')}}</h5>
      </div>
    @endif
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">今月の出勤時間の棒状チャート図</div>
                  @include('sub_view.attendance_card',['user_names' => $user_names, 'late_times' => $late_times])
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">3ヶ月間の欠勤（予定）回数の棒状チャート図</div>
                  @include('sub_view.leave_times',['user_names' => $user_names,
                                                   'this_month_leave_times' => $this_month_leave_times,
                                                   'next_month_leave_times' => $next_month_leave_times,
                                                   'month_after_next_month_leave_times' => $month_after_next_month_leave_times])
            </div>
        </div>
    </div>
</div>
@endsection
