@extends('layouts.app')
@section('title','遅刻照会')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
          @include('sub_view.admin_attendance_card',
            [
              'late_user_names' => $late_user_names,
              'late_times' => $late_times
            ])
        </div>
    </div>
</div>
<div class="container" style="margin-top:30px">
    <div class="row justify-content-center">
        <div class="col-md-8">
          @include('sub_view.leave_times_card',
          [
            'leave_user_names' => $leave_user_names,
            'this_month_leave_times' => $this_month_leave_times,
            'next_month_leave_times' => $next_month_leave_times,
            'month_after_next_month_leave_times' => $month_after_next_month_leave_times
          ])
        </div>
    </div>
</div>
@endsection
