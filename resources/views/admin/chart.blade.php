@extends('layouts.app')
@section('title','遅刻照会')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
          @include('sub_view.attendance_card',['user_names' => $user_names, 'late_times' => $late_times])
        </div>
    </div>
</div>
<div class="container" style="margin-top:30px">
    <div class="row justify-content-center">
        <div class="col-md-8">
          @include('sub_view.leave_times_card',
          [
            'user_names' => $user_names,
            'this_month_leave_times' => $this_month_leave_times,
            'next_month_leave_times' => $next_month_leave_times,
            'month_after_next_month_leave_times' => $month_after_next_month_leave_times
          ])
        </div>
    </div>
</div>
@endsection
