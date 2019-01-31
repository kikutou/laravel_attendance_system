@extends('layouts.app')

@section('title','休暇申請')

@section('content')
<link rel="stylesheet" href="{{ asset('css/jquery.timepicker.css') }}">
<script src="{{ asset('js/jquery.timepicker.min.js') }}"></script>

<script type="text/javascript">
$( function () {
  $( "#start_day" ).datepicker();
});
</script>

<div class="row" style="margin-left:200px;margin-top:100px">
  <div class="col-md-12">
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
         <td style="text-align:center"><label for="start_day">欠勤日</label></td>
         <td><input id="start_day" name="attendance_date" type="text" value="{{ old('attendance_date') }}"></td>
        </tr>
        <tr>
         <td style="text-align:center"><label for="start_hour">欠勤開始時間</label></td>
         <td><select name="start_hour">
        		 @for($i = 8; $i <= 31; $i++)
                @if($i < 24)
                 <option>{{ $i < 10 ? "0".$i:$i }}</option>
                @else <option>{{ "0".($i-24) }}</option>
                @endif
             @endfor
        		</select> :
            <select name="start_minute">
             @for($i = 0; $i <= 45; $i+=15)
              <option>{{ $i < 10 ? "0".$i:$i }}</option>
             @endfor
            </select></td>
        </tr>
        <tr>
         <td style="text-align:center"><label for="end_hour">欠勤終了時間</label></td>
         <td><select name="end_hour">
        		 @for($i = 8; $i <= 31; $i++)
                @if($i < 24)
                 <option>{{ $i < 10 ? "0".$i:$i }}</option>
                @else <option>{{ "0".($i-24) }}</option>
                @endif
             @endfor
        		</select> :
            <select name="end_minute">
             @for($i = 0; $i <= 45; $i+=15)
              <option>{{ $i < 10 ? "0".$i:$i }}</option>
             @endfor
            </select></td>
        </tr>
        <tr>
         <td style="text-align:center"><label for="reason">申請理由</label></td>
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
