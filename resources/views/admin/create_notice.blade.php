@extends('layouts.app')
@section('title','通知関連')
@section('content')
<script>
  $(function(){
    $('#show_time').datepicker();
  })
</script>
<script>
//すべてのcheckboxを選択。
$(function(){
  $('#all_users').click(function() {
      if(this.checked) {
          $(':checkbox').each(function() {
              this.checked = true;
          });
      } else {
          $(':checkbox').each(function() {
              this.checked = false;
          });
      }
  });
})
$(function(){
  $(':checkbox').not('#all_users').click(function(){
    var count =  0;
    var len = $(':checkbox').length-1;
    $(':checkbox').not('#all_users').each(function(){
      if(!this.checked){
        $('#all_users').prop('checked',false);
      } else {
        count++;
      }
      if(count == len){
        $('#all_users').prop('checked',true);
      }
    });
  });
})
</script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                  <span>お知らせの新規登録</span>
                  <span style="float:right"><a href="{{ route('get_all_info') }}">お知らせ一覧へ</a></span>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                      <form action="{{ route('post_create_notice') }}" method="post">
                        @csrf
                        <li class="list-group-item" style="border:0px"><span class="person-info-title">公開日時</span>
                          <input id='show_time' class="form-control" name="show_date" type="text" value="{{ old('show_date') }}" autocomplete="off" placeholder="お知らせ日時を選択してください">
                        </li>
                        <li class="list-group-item" style="border:0px"><span class="person-info-title">タイトル</span>
                          <input class="form-control" name="title" type="text" value="{{ old('title') }}" placeholder="タイトルを入力してください">
                        </li>
                        <li class="list-group-item" style="border:0px"><span class="person-info-title">内容</span>
                          <textarea class="form-control" name="comment" placeholder="内容を入力してください">{{ old('comment') }}</textarea>
                        </li>
                        <li class="list-group-item" style="border:0px;"><span class="person-info-title">送信先</span>
                          <div class="checkbox checkbox-primary checkbox-inline form-control"style="height:auto;overflow:auto">
                            @foreach($users as $user)
                              <span style="float: left">
                                <input id="user{{ $user->id }}" type="checkbox" name="user_ids[]" value="{{ $user->id }}"
                                @if(old('user_ids') && in_array($user->id,old('user_ids')))
                                 checked
                                 @endif>
                                <label for="user{{ $user->id }}">{{ $user->name }}@if($user->admin_flg)（管理員）@else &nbsp;&nbsp;@endif</label>
                              </span>
                            @endforeach
                              <span style="float: left">
                                <input id="all_users" type="checkbox" name="all_users">
                                <label for="all_users">すべて&nbsp;&nbsp;</label>
                              </span>
                         </div>
                        </li>
                        <li class="list-group-item" style="text-align:center;border:0px">
                          <input type="submit" class="btn btn-primary" value="作成">
                          <input style="margin-left:50px" type="reset" class="btn btn-primary" value="リセット">
                        </li>
                      </form>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
