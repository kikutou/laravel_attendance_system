@extends("layouts.app")

@section("content")

<div class="container">
  @if(Session::has('message'))
    <div style="width:500px;margin:0 auto">
      <h5>{{ Session::get('message')}}</h5>
    </div>
  @endif
  @if($users->count() == 0)
    <div style="width:500px;margin:0 auto">
      <h5>すべての会員が認証済みです。</h5>
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
                  <li class="list-group-item"><span class="person-info-title">Eメール&nbsp:</span>&nbsp{{$user->email}}</li>
                  <li class="list-group-item"><span class="person-info-title">電話番号&nbsp:</span>&nbsp{{ $user->telephone_number }}</li>
                  <li class="list-group-item">
                    <div class="form-inline" style="width:200px;margin:0 auto">
                      <form action="{{ route('post_mail_check') }}" method="post">
                        @csrf
                        <input type="hidden" name="yes" value="yes">
                        <input type="hidden" name="id" value="{{ $user->id }}">
                        <input onclick="return clear1()" type="submit" class="btn btn-primary" value="承認">
                        <input style="margin-left:50px" onclick="return clear1()" type="submit" class="btn btn-primary" value="削除">
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
    <!-- <div id="content" class="container-fluid">
        <div class="col-sm text-center top36 bottom36">
          <p>会員認証リスト</p>
        </div>
        <div class="col-sm text-center top36 bottom36">
          <div class="media row top36 bottom36">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">

              @if(Session::has("message"))
                <p>{{ Session::get("message") }}</p>
              @endif

              @if($users->count() == 0)
                <p>すべての会員が認証済みです。</p>
              @endif
              @foreach($users as $user)
                <div id="top">
                  <div class="event_content row bg-light top1">
                    <div class="col-sm-12">

                      <div id="socool" class="row top36">
                        <div class="col-sm-6 text-center">従業員</div>
                        <div class="col-sm-6 text-center">{{ $user->name }}</div>
                      </div>
                      <div id="socool" class="row top6">
                        <div class="col-sm-6 text-center">email</div>
                        <div class="col-sm-6 text-center">
                          {{ $user->email }}
                        </div>
                      </div>
                      <div id="socool" class="row top6">
                        <div class="col-sm-6 text-center">telephone_number</div>
                        <div class="col-sm-6 text-center">
                          {{ 	$user->telephone_number }}
                        </div>
                      </div>
                      <div class="row top36">
                        <div class="col-sm text-center">
                          <div class="row">
                            <div class="col-sm-6 text-right">
                              <form action="{{ route('post_mail_check') }}" method="post">
                                @csrf
                                <input type="hidden" name="yes" value="yes">
                                <input type="hidden" name="id" value="{{ $user->id }}">
                                <input onclick="return clear1()" type="submit" value="承認">
                              </form>
                            </div>
                            <div class="col-sm-6 text-left">
                              <form action="{{ route('post_mail_check') }}" method="post">
                                @csrf
                                <input type="hidden" name="no" value="no">
                                <input type="hidden" name="id" value="{{ $user->id }}">
                                <input onclick="return clear1()" type="submit" value="削除">
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
            <div class="col-sm-2"></div>
          </div>
        </div>
    </div> -->
@endsection
