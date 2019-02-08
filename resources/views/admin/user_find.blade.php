@extends("layouts.app")
@section("title","勤怠検索")
@section("content")
<link href="{{ asset('/css/tao.css') }}" rel="stylesheet">
<script>
 $(function(){
   $("#start,#end").datepicker();
 })
</script>
<div>
  @if($errors->any())
    @foreach($errors->all() as $error)
      <p>{{ $error }}</p >
    @endforeach
  @endif
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">勤怠検索</div>
                <div class="card-body" style="margin-right:50px">
                  <form method="get" action="{{ route('get_user_find') }}">
                      @csrf
                      <input type="hidden" name="search" value="yes">
                      <div class="form-group row">
                          <label for="name" class="col-md-4 col-form-label text-md-right">名前</label>

                          <div class="col-md-6">
                            <select name="user_id" id="name" class="form-control">
                              <option value="all">名前を選択してください</option>
                              @foreach($users as $user)
                                <option value="{{ $user->id }}"
                                    @if(Request::query('user_id') && Request::query('user_id') == $user->id)
                                      selected
                                    @endif
                                  >{{ $user->name }}</option>
                              @endforeach
                            </select>
                          </div>
                      </div>

                      <div class="form-group row">
                          <label for="start" class="col-md-4 col-form-label text-md-right">何日から</label>

                          <div class="col-md-6">
                              <input type="text" id="start" name="start" class="form-control" autocomplete="off" value="{{ Request::query('start') }}">
                          </div>
                      </div>

                      <div class="form-group row">
                          <label for="end" class="col-md-4 col-form-label text-md-right">何日まで</label>

                          <div class="col-md-6">
                              <input type="text" id="end" name="end" class="form-control" autocomplete="off" value="{{ Request::query('end') }}">
                          </div>
                      </div>

                      <div class="form-group row mb-0">
                          <div class="col-md-6 offset-md-6">
                              <button type="submit" class="btn btn-primary">
                                検索
                              </button>
                          </div>
                      </div>
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>

  @if ($attendance_records)
    <h3>勤怠表</h3>
    @foreach ($users_rec as $user_rec)
      @include("sub_view.attendance_info_table", ["user" => $user_rec, "days" => $diff, "thisday" => $endtime])
      <div class="row">
        <div class="col-sm text-center">
          <a href="{{ route('get_create_csv_find', ['starttime' => $starttime, 'endtime' => $endtime, 'user_id' => $user_rec->id]) }}">CSVファイルで勤怠状況を出力</a>
        </div>
      </div>
    @endforeach

  @endif

@endsection
