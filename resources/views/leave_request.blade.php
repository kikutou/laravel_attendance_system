@extends('layouts.app')

@section('title','休暇申請')

@section('content')

<script type="text/javascript">
$(function () {
    $("#start_day").datepicker();
});
</script>
<div class="row" style="margin-left:200px;margin-top:100px">
  <div class="col-md-12">

      <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
      <link rel="stylesheet" href="/resources/demos/style.css">
      <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
      <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
      <script>
          $( function() {
              $( "#start_day" ).datepicker();
          } );
      </script>

    <form action="{{ route('post_leave_request') }}" method="post">
      @csrf

      <div style="margin-left:20px">
        @if($errors->any())
         @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
         @endforeach
        @endif
      </div>
      <div style="margin-left:20px">
        @if(Session::has('one_message'))
          <li>{{ Session::get('one_message') }}</li>
        @endif
      </div>
      <table class="table">
        <tr>
         <td><label for="start_day">欠勤日</label></td>
         <td><input id="start_day" name="attendance_date" type="text" value="{{ old('attendance_date') }}"></td>
        </tr>
        <tr>
         <td><label for="start">欠勤開始時間</label></td>
         <td><input id="start" name="leave_start_time" type="text" value="{{ old('leave_start_time') }}">(例: 10:30)</td>
        </tr>
        <tr>
         <td><label for="end">欠勤終了時間</label></td>
         <td><input id="end" name="leave_end_time" type="text" value="{{ old('leave_end_time') }}">(例: 20:30)</td>
        </tr>
        <tr>
         <td><label for="reason">申請理由</label></td>
         <td><textarea id="reason" name="leave_reason" rows="5" cols="25">{{ old('leave_reason') }}</textarea></td>
        </tr>
        <tr>
         <td style="text-align:center"><input type="submit" value="申請"></td>
         <td><input type="reset" value="リセット"></td>
        </tr>
      </table>
    </form>
  </div>
</div>

@endsection
