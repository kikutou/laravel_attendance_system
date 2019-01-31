@extends('layouts.app')

@section('title','CreateNotice')

@section('content')
<script>
  $(function(){
    $('#show_time').datepicker();
  })
</script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">お知らせの新規登録</div>
                <div class="card-body">
                    <ul class="list-group">
                      <form action="" method="post">
                        <li class="list-group-item"><span class="person-info-title">お知らせ日時</span>
                          <input id='show_time' class="form-control" name="show_time" type="text" value="{{ old('show_time') }}" placeholder="お知らせ日時を選択してください">
                        </li>
                        <li class="list-group-item"><span class="person-info-title">タイトル</span>
                          <input class="form-control" name="title" type="text" value="{{ old('title') }}" placeholder="タイトルを入力してください">
                        </li>
                        <li class="list-group-item"><span class="person-info-title">内容</span>
                          <textarea class="form-control" name="content"placeholder="内容を入力してください">{{ old('content') }}</textarea>
                        </li>
                        <li class="list-group-item"><span class="person-info-title">送信先</span>
                          <div class="checkbox-inline form-control">
                            <input type="checkbox" name="user_id" value="{{ old('user_id') }}">
                            <input type="checkbox" name="user_id" value="{{ old('user_id') }}">
                          </div>
                        </li>
                        <li class="list-group-item" style="text-align:center">
                          <input type="submit" class="btn btn-primary" value="作成">
                          <input type="reset" class="btn btn-primary" value="リセット">
                        </li>
                      </form>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
