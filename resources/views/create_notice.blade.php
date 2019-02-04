@extends('layouts.app')

@section('title','CreateNotice')

@section('content')
<script>
  $(function(){
    $('#show_time').datepicker();
  })
</script>
<script>

//すべてのcheckboxを選択。
$(function(){
$("#all_users").click(function(){
    $('input:checkbox').not(this).prop('checked', this.checked);
  });
})
</script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                  <span>お知らせの新規登録</span>
                  <span style="float:right"><a href="{{ route('get_all_info') }}" style="text-decoration:none">お知らせ一覧</a></span></div>
                <div class="card-body">
                    <ul class="list-group">
                      <form action="{{ route('post_create_notice') }}" method="post">
                        @csrf
                        <li class="list-group-item"><span class="person-info-title">お知らせ日時</span>
                          <input id='show_time' class="form-control" name="show_date" type="text" value="{{ old('show_date') }}" placeholder="お知らせ日時を選択してください">
                        </li>
                        <li class="list-group-item"><span class="person-info-title">タイトル</span>
                          <input class="form-control" name="title" type="text" value="{{ old('title') }}" placeholder="タイトルを入力してください">
                        </li>
                        <li class="list-group-item"><span class="person-info-title">内容</span>
                          <textarea class="form-control" name="comment" placeholder="内容を入力してください">{{ old('comment') }}</textarea>
                        </li>
                        <li class="list-group-item"><span class="person-info-title">送信先</span>
                          <div class="checkbox-inline form-control"style="height:auto">
                            @foreach($users as $user)
                              @continue($user->admin_flg)
                                <input type="checkbox" name="user_ids[]" value="{{ $user->id }}"
                                 @if(old('user_ids') && in_array($user->id,old('user_ids')))
                                  checked
                                 @endif>&nbsp{{ $user->name }}
                            @endforeach
                              <br><input id="all_users" type="checkbox" name="all_users">&nbspすべて
                          </div>
                        </li>
                        <li class="list-group-item" style="text-align:center">
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
