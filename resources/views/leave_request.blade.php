@extends('layouts.app')

@section('title','休暇申請')

@section('content')
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
 <script src="//code.jquery.com/jquery-1.9.1.js"></script>
 <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
 <link rel="stylesheet" href="http://jqueryui.com/resources/demos/style.css">
<style>
 #div_form{
   width:500px;
   margin:0 auto;
 }
</style>
<div id="div_form">
  <script>
      $(document).ready(function(){
          $("#start_day").datepicker();
      });
  </script>
  <form action="{{ route('post_leave_request') }}" method="post">
    @csrf
    <div style="margin-left:20px">
      @if($errors->any())
       @foreach($errors->all() as $error)
        <h5>{{ $error }}</h5>
       @endforeach
      @endif
    </div>
    @if(Session::has('one_message'))
      <div style="margin-left:20px">
        <h5 style="width:300px">{{ Session::get('one_message') }}</h5>
      </div>
    @endif
    　<div class="form-group">
         <label for="start_day" class="col-sm-4 control-label">欠勤日</label>
         <div class="col-sm-8">
           <input id="start_day" class="form-control" name="attendance_date" type="text" value="{{ old('attendance_date') }}">
         </div>
      </div>
      <div class="form-group" style="margin-top:20px">
         <label for="start" class="col-sm-4 control-label">欠勤開始時間</label>
         <div class="col-sm-8">
           <div class="row">
             <div class="col-sm-6">
               <select id="start" class="form-control" name="leave_start_hour" type="text" value="{{ old('leave_start_hour') }}">
                 @for($i = 8;$i <=31; $i++)
                  @if($i < 24)
                   <option value="{{ $i < 10 ? "0".$i : $i }}">{{ $i < 10 ? "0".$i : $i }}</option>
                  @else
                   <option value="{{ "0".($i-24)  }}">{{ "0".($i-24) }}</option>
                  @endif
                 @endfor
               </select>
             </div>
             <div class="col-sm-6">
               <select id="start" class="form-control" name="leave_start_minute" type="text" value="{{ old('leave_start_minute') }}">
                 @for($i = 0;$i <= 45; $i += 15)
                   <option value="{{ $i ==0 ? "0".$i : $i }}">{{ $i ==0 ? "0".$i : $i }}</option>
                 @endfor
               </select>
            </div>
         </div>
      </div>
      <div class="form-group" style="margin-top:20px">
         <label for="start" class="col-sm-4 control-label">欠勤終了時間</label>
         <div class="col-sm-8">
           <div class="row">
             <div class="col-sm-6">
               <select id="end" class="form-control" name="leave_end_hour" type="text" value="{{ old('leave_end_hour') }}">
                 @for($i = 8;$i <=31; $i++)
                  @if($i < 24)
                   <option value="{{ $i < 10 ? "0".$i : $i }}">{{ $i < 10 ? "0".$i : $i }}</option>
                  @else
                   <option value="{{ "0".($i-24) }}">{{ "0".($i-24) }}</option>
                  @endif
                 @endfor
               </select>
             </div>
             <div class="col-sm-6">
               <select id="end" class="form-control" name="leave_end_minute" type="text" value="{{ old('leave_end_minute') }}">
                 @for($i = 0;$i <= 45; $i += 15)
                   <option value="{{ $i ==0 ? "0".$i : $i }}">{{ $i ==0 ? "0".$i : $i }}</option>
                 @endfor
               </select>
            </div>
         </div>
      </div>
      <div class="form-group" style="margin-top:20px">
         <label for="reason" class="col-sm-4 control-label">申請理由</label>
         <div class="col-sm-8">
           <textarea id="reason" class="form-control" name="leave_reason" rows="5" cols="25">{{ old('leave_reason') }}</textarea>
         </div>
      </div>
      <div class="btn-group" style="margin-left:60px">
         <div class="col-sm-6">
           <input type="submit" class="btn btn-primary" value="申請">
         </div>
         <div class="col-sm-6">
           <input type="reset" class="btn btn-primary"value="リセット">
         </div>
     </div>
  </form>
</div>

@endsection
