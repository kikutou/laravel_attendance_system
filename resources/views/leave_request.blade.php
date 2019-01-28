@extends('layouts.layout')

@section('title','休暇申請')

@section('content')

<div class="row">
  <div class="col-md-2"></div>
  <div class="col-md-8">

    <form action="{{ route('post_leave_request') }}" method="post">
      @csrf
      <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
      <div>
        <label for="start">いつから</label>
        <input id="start" name="leave_start_time" type="text">
      </div>
      <div>
        <label for="end">いつまで</label>
        <input id="end" name="leave_end_time" type="text">
      </div>
      <div>
        <label for="reason">申請理由</label>
        <input id="reason" name="leave_reason" type="text">
      </div>
      <div>
        <input type="submit" value="申請">
      </div>
    </form>

  </div>
  <div class="col-md-2"></div>
</div>

@endsection
