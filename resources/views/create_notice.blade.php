@extends('layouts.app')

@section('title','CreateNotice')

@section('content')

 <form action="{{ route('post_create_notice')}}" method="post">
     <div class="form-group">
       <label for="show_time" class="col-sm-2 control-label">お知らせ時間</label>
       <div class="col-sm-10">
         <input id="show_time" class="form-control" type="text" placeholder="お知らせ時間を入力してください">
       </div>
     </div>
     <div class="form-group">
       <label for="title" class="col-sm-2 control-label">タイトル</label>
       <div class="col-sm-10">
         <input id="title" class="form-control" type="text" placeholder="タイトルを入力してください">
       </div>
     </div>
 </form>
@endsection
