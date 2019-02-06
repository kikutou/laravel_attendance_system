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
                      <div class="form-group row">
                          <label for="name" class="col-md-4 col-form-label text-md-right">名前</label>

                          <div class="col-md-6">
                            <select name="user_id" id="name" class="form-control">
                              <option value="">名前を選択してください</option>
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
<!-- <div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
          <div class="card-header">
            <span>勤怠検索</span>
          </div>
              <div class="card-body">
                <ul class="list-group" style="text-align:center">
                    <form action="{{ route('get_user_find') }}" method="get">
                      @csrf
                      　<li class="list-group-item">
                         <span class="person-info-title">名前</span>
                          <select name="user_id" id="tao">
                            <option value="">名前を選択してくださいます</option>
                            @foreach($users as $user)
                              <option value="{{ $user->id }}"
                                  @if(Request::query('user_id') && Request::query('user_id') == $user->id)
                                    selected
                                  @endif
                                >{{ $user->name }}</option>
                            @endforeach
                          </select>
                        </li>
                        <li class="list-group-item">
                          <span class="person-info-title">何日から</span>
                          <input type="date" id="tao0" name="start" value="{{ Request::query('start') }}">
                        </li>
                        <li class="list-group-item">
                          <span class="person-info-title">何日まで</span>
                          <input type="date" id="tao1" name="end" value="{{ Request::query('end') }}">
                        </li>
                        <li class="list-group-item">
                          <input type="submit" id="tao" class="btn btn-primary" value="検索">
                        </li>
                    </form>
                </ul>
            </div>
        </div>
     </div>
  </div>
</div> -->
@if($attendance_records)
<h3>勤怠表</h3>
<div class="row">
  <div class="col-sm-8"></div>
  <div class="col-sm-4 top1">名前:{{ $user_name }}</div>
</div>

<div id="cools"class="row">
  @for ($i=$diff; $i>=0; $i--)
    @php
    $this_date = $starttime->addDay(1);
    $show_record = null;
    @endphp
    <table class="top table table-striped">
      <tr>
        <th>日付</th>
        <th>出勤時間</th>
        <th>退勤時間</th>
      </tr>
      <tr>
        @foreach ($attendance_records as $attendance_record)
            @if ($attendance_record->attendance_date == $this_date)
              @php
                $show_record = $attendance_record;
              @endphp
              @break
            @endif
        @endforeach

        @if ($show_record)
          <td>
            {{ $show_record->attendance_date->format('Y年n月j日') }}<br>

            @if( $show_record->leave_start_time && $show_record->start_time == null )
              <button id="cool" class="btn btn-primary btn-lg"  data-toggle="modal" data-target="#myModal{{ $show_record->id }}" >
                休み情報
              </button>
              <div class="modal fade" id="myModal{{ $show_record->id }}" tabindex="-1" role="dialog" aria-labelledby="#myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">

                      <h4 class="modal-title abb" id="myModalLabel">
                        休み情報
                      </h4>
                    </div>
                    <div class="modal-body">
                      <div style="text-align:center">
                        <div class="card-header" style="text-align:left">1. 欠勤開始時間:&nbsp;{{ $show_record->leave_start_time ??"出勤していません。" }}</div>
                        <div class="card-header" style="text-align:left">2. 欠勤終了時間:&nbsp;{{ $show_record->leave_end_time ??"出勤していません。" }}</div>
                        <div class="card-header" style="text-align:left">3. 欠勤理由:<br>&nbsp;{!! nl2br(e($show_record->leave_reason ??"出勤していません。")) !!}</div>
                        <div class="card-header" style="text-align:left">4. 欠勤承認状態:&nbsp;@if ($show_record && $show_record->mtb_leave_check_status_id == 1)
                        承認待ち
                        @elseif ($show_record && $show_record->mtb_leave_check_status_id == 2)
                        承認済
                        @elseif ($show_record && $show_record->mtb_leave_check_status_id == 3)
                        断り
                        @elseif(!$show_record || !$show_record->mtb_leave_check_status_id)
                        出勤していません。
                        @endif</div>
                        <div class="card-header" style="text-align:left">5. 欠勤申請時間:&nbsp;{{ $show_record->leave_applicate_time??"出勤していません。" }}</div>
                        <div class="card-header" style="text-align:left">6. 承認時間:&nbsp;{{ $show_record->leave_check_time??"出勤していません。" }}</div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                      </button>
                    </div>
                  </div><!-- /.modal-content -->
                </div><!-- /.modal -->
              </div>
            </div>
          @endif
          </td>
          <td>{{ $show_record->start_time }}</td>
          <td>{{ $show_record->end_time }}</td>
        @else
          <td>{{ $this_date->format('Y年n月j日') }}</td>
          <td>出勤していません。</td>
          <td>出勤していません。</td>
        @endif

      </tr>
    </table>
  @endfor
</div>
  @else

  @endif
@endsection
