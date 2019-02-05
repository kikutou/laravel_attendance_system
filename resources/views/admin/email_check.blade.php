@extends("layouts.app")
@section('title','会員認証')
@section("content")

<div class="container">
  @if(Session::has('message'))
    <div style="width:500px;margin:0 auto">
      <h5 style="text-align:center">{{ Session::get('message')}}</h5>
    </div>
  @endif
  @if($users->count() == 0)
    <div style="width:500px;margin:0 auto">
      <h5 style="text-align:center">すべての会員が認証済みです。</h5>
    </div>
  @endif
  <div class="row justify-content-center">
      <div class="col-md-8">
          <div class="card">
              <div class="card-header">会員認証リスト</div>
              <div class="card-body">
                <ul class="list-group">
                @foreach($users as $user)
                  <li class="list-group-item"><span class="person-info-title">従業員&nbsp:</span>&nbsp{{ $user->name }}</li>
                  <li class="list-group-item"><span class="person-info-title">Eメール&nbsp:</span>&nbsp{{ $user->email }}</li>
                  <li class="list-group-item"><span class="person-info-title">電話番号&nbsp:</span>&nbsp{{ $user->telephone_number }}</li>
                  <li class="list-group-item">
                    <div class="form-inline" style="width:200px;margin:0 auto">
                      <form action="{{ route('post_mail_check') }}" method="post">
                        @csrf
                        <input type="hidden" name="confirmOrNOt" value="yes">
                        <input type="hidden" name="id" value="{{ $user->id }}">
                        <input type="submit" class="btn btn-primary" value="承認">
                        <input style="margin-left:50px" type="submit" name="delete" class="btn btn-primary" value="削除">
                      </form>
                    </div>
                  </li>
                @endforeach
                </ul>
              </div>
          </div>
      </div>
  </div>
</div>

@endsection
