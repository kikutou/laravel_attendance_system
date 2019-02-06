<table class="top table table-striped">
    <tr>
        <th>日付</th>
        <th>出勤時間</th>
        <th>退勤時間</th>
        <th>遅刻理由</th>
        <th>休み情報</th>
    </tr>

@foreach($user->get_recent_attendance_records() as $date => $record)

  <tr>

    @if ($record["status"] != "no attendance")
          <td>{{ $date }}</td>
          <td>{{ $record["start_time"] }}</td>
          <td>{{ $record["end_time"] }}</td>
          <td>{{ nl2br($record["reason"]) }}</td>
      <td>
        @if( $record["leave_status"] )

          <button id="cool" class="btn btn-primary btn-sm"  data-toggle="modal" data-target="#myModal{{ $date }}" >
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

    @else
      <td>{{ $date }}</td>
      <td colspan="4">出勤していません。</td>
    @endif

  </tr>




@endforeach

</table>
