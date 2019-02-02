@extends('layouts.app')

@section('title','休暇申請')

@section('content')
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
 <script src="//code.jquery.com/jquery-1.9.1.js"></script>
 <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
 <link rel="stylesheet" href="http://jqueryui.com/resources/demos/style.css">

<div class="container">
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
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
           <div class="card-header">欠勤申込</div>
           <div class="card-body">
             <ul class="list-group">
               <li class="list-group-item">
                 <span class="person-info-title">欠勤日</span>
                 <input id="start_day" class="form-control" name="attendance_date" type="text" value="{{ old('attendance_date') }}" placeholder="欠勤日を選択してください">
               </li>
               <li class="list-group-item">
                 <span class="person-info-title">欠勤開始時間</span>
                 <div class="form-inline">
                   <select class="form-control" name="leave_start_hour" style="width:310px">
                     <option value="">時を選択してください</option>
                     @for($i = 8;$i <=31; $i++)
                      @if($i < 24)
                       <option value="{{ $i < 10 ? "0".$i : $i }}"
                         @if(old('leave_start_hour') && old('leave_start_hour') == ($i < 10 ? "0".$i : $i) )
                           selected
                         @endif>{{ $i < 10 ? "0".$i : $i }}</option>
                      @else
                       <option value="{{ "0".($i-24)  }}"
                         @if(old('leave_start_hour') && old('leave_start_hour') == "0".($i-24))
                           selected
                         @endif>{{ "0".($i-24) }}</option>
                      @endif
                     @endfor
                   </select>
                   <div style="width:25px"><p style="text-align:center">:</p></div>
                   <select class="form-control" name="leave_start_minute" style="width:310px">
                     <option value="">分を選択してください</option>
                     @for($i = 0;$i <= 45; $i += 15)
                       <option value="{{ $i ==0 ? "0".$i : $i }}"
                         @if(old('leave_start_minute') && old('leave_start_minute') == ($i ==0 ? "0".$i : $i) )
                           selected
                         @endif>{{ $i ==0 ? "0".$i : $i }}</option>
                     @endfor
                   </select>
                 </li>
                 <li class="list-group-item">
                   <span class="person-info-title">欠勤終了時間</span>
                   <div class="form-inline">
                     <select class="form-control" name="leave_end_hour" style="width:310px">
                       <option value="">時を選択してください</option>
                       @for($i = 8;$i <= 31; $i++)
                        @if($i < 24)
                         <option value="{{ $i < 10 ? "0".$i : $i }}"
                           @if(old('leave_end_hour') && old('leave_end_hour') == ($i < 10 ? "0".$i : $i) )
                             selected
                           @endif>{{ $i < 10 ? "0".$i : $i }}</option>
                        @else
                         <option value="{{ "0".($i-24)  }}"
                           @if(old('leave_end_hour') && old('leave_end_hour') == "0".($i-24))
                             selected
                           @endif>{{ "0".($i-24) }}</option>
                        @endif
                       @endfor
                     </select>
                     <div style="width:25px"><p style="text-align:center">:</p></div>
                     <select class="form-control" name="leave_end_minute" style="width:310px">
                       <option value="">分を選択してください</option>
                       @for($i = 0;$i <= 45; $i += 15)
                         <option value="{{ $i ==0 ? "0".$i : $i }}"
                           @if(old('leave_end_minute') && old('leave_end_minute') == ($i ==0 ? "0".$i : $i) )
                             selected
                           @endif>{{ $i == 0 ? "0".$i : $i }}</option>
                       @endfor
                     </select>
                 </div>
               </li>
               <li class="list-group-item">
                 <span class="person-info-title">申請理由</span>
                 <textarea class="form-control" name="leave_reason" rows="5" placeholder="申請理由を入力してください">{{ old('leave_reason') }}</textarea>
               </li>
               <li class="list-group-item" style="text-align:center">
                   <input type="submit" class="btn btn-primary" value="申請">
                   <input type="reset" class="btn btn-primary"value="リセット">
               </li>
             </ul>
           </div>
         </div>
       </div>
     </div>
   </div>
 </form>
</div>

@endsection
