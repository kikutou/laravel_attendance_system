@extends("layouts.app")
@section("title","出勤状態")
@section("content")
  <link href="{{ asset('/css/tao.css') }}" rel="stylesheet">
    <h3>一週間の勤怠表</h3>
    <div class="row">
      <div class="col-sm-8"></div>
      <div class="col-sm-4 top1">名前:{{ Auth::user()->name }}</div>
    </div>
    <div id="cools"class="row">


      @foreach(Auth::user()->get_recent_attendance_records() as $date => $record)
        <table class="top table table-striped">
          <tr>
            <th>日付</th>
            <th>出勤時間</th>
            <th>退勤時間</th>
          </tr>
          <tr>

            @if ($record["status"] != "no attendance")
              <td>{{ $date }}<br>
                @if( $record["leave_status"] )

                  <button id="cool" class="btn btn-primary btn-lg"  data-toggle="modal" data-target="#myModal{{ $date }}" >
                    休み情報
                  </button>
                  <div class="modal fade" id="myModal{{ $date }}" tabindex="-1" role="dialog" aria-labelledby="#myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">

                          <h4 class="modal-title abb" id="myModalLabel">
                            休み情報
                          </h4>
                        </div>
                        <div class="modal-body">
                          <div style="text-align:center">
                            <div class="card-header" style="text-align:left">1. 欠勤開始時間:&nbsp;{{ $record["leave_start_time"] }}</div>
                            <div class="card-header" style="text-align:left">2. 欠勤終了時間:&nbsp;{{ $record["leave_end_time"] }}</div>
                            <div class="card-header" style="text-align:left">3. 欠勤理由:<br>&nbsp;{!! nl2br(e($record["leave_reason"])) !!}</div>
                            <div class="card-header" style="text-align:left">4. 欠勤承認状態:&nbsp;{{ $record["mtb_leave_check_status"] }}</div>
                            <div class="card-header" style="text-align:left">5. 欠勤申請時間:&nbsp;{{ $record["leave_applicate_time"] }}</div>
                            <div class="card-header" style="text-align:left">6. 承認時間:&nbsp;{{ $record["leave_check_time"] }}</div>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                          </button>
                        </div>
                      </div><!-- /.modal-content -->
                    </div><!-- /.modal -->
                  </div>
              @endif
              </td>
              <td>{{ $record["start_time"] }}</td>
              <td>{{ $record["end_time"] }}</td>
            @else
              <td>{{ $date }}</td>
              <td>出勤していません。</td>
              <td>出勤していません。</td>
            @endif

          </tr>


        </table>

       @endforeach

    </div>
    <div class="row">
      <div class="col-sm text-center">
        <a href="{{ route('get_create_csv') }}">本月の勤怠状況を確認しましたか？</a>
      </div>
    </div>
@endsection
