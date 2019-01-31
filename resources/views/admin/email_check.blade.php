@extends("layouts.app")

@section("content")
    <div id="content" class="container-fluid">
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
    </div>
@endsection
