@extends("layouts.app")

@section("content")
  <link href="{{ asset('/css/tao.css') }}" rel="stylesheet">
  <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <h3>一週間の勤怠表</h3>
    <div class="row">
      <div class="col-sm-8"></div>
      <div class="col-sm-4 top1">名前:{{ Auth::user()->name }}</div>
    </div>
    <div id="cools"class="row">
      @for ($i=6; $i>=0; $i--)
        @php
        $this_date = \Carbon\Carbon::today()->subDay($i);
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
              <td>{{ $show_record->attendance_date->format('Y年n月j日') }}<br>
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
    <div class="row">
      <div class="col-sm text-center">
        <a href="{{ route('get_create_csv') }}">本月の勤怠状況を確認しましたか？</a>
      </div>
    </div>
@endsection
