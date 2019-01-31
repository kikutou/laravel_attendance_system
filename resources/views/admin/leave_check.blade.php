<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/4.1.0/css/bootstrap.min.css">
    <script src="https://cdn.staticfile.org/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/popper.js/1.12.5/umd/popper.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/4.1.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.staticfile.org/jquery/1.10.2/jquery.min.js"></script>


    <title></title>
    <link rel="stylesheet" href="{{asset('/css/leavecheck.css')}}">

  {{--<script src="{{ asset('js/leavecheck.js') }}" defer></script>--}}
  </head>

  <body>
    @if(Session::has("message"))
      <p>{{ Session::get("message") }}</p>
    @endif
    <div id="content" class="container-fluid">
        <div class="col-sm text-center top36 bottom36">
          <p>休み請求一覧</p>
        </div>

        <div class="col-sm text-center top36 bottom36">

        <div class="media row top36 bottom36">
          <div class="col-sm-2"></div>

          <div class="col-sm-8">

            <div class="row text-center cool">
              <!-- 三元运算 -->
              <div class="col-sm-2 {{ ($current_page=='all') ? 'current' : '' }}">
                <a href="/check">すべて</a>
              </div>
              <div class="col-sm-2 {{ ($current_page=='approval_pending') ? 'current' : '' }}">
                <a href="/check/approval_pending">未承認</a>
              </div>
              <div class="col-sm-2 {{ ($current_page=='approval') ? 'current' : '' }}">
                <a href="/check/approval">承認済み</a>
              </div>
              <div class="col-sm-2 {{ ($current_page=='refuse') ? 'current' : '' }}">
                <a href="/check/refuse">断り</a>
              </div>
            </div>
            @foreach($attendancerecords as $attendancerecord)
            <div id="top">
              <div class="event_content row bg-light top1">
                <div class="col-sm-12">

                  <div id="socool" class="row top36">
                    <div class="col-sm-6 text-center">従業員</div>
                    <div class="col-sm-6 text-center">{{ $attendancerecord->users->name }}</div>
                  </div>
                  <div id="socool" class="row top6">
                    <div class="col-sm-6 text-center">欠勤開始時間</div>
                    <div class="col-sm-6 text-center">
                      {{ $attendancerecord->attendance_date->format("Y年n月j日") . $attendancerecord->leave_start_time }}
                    </div>
                  </div>
                  <div id="socool" class="row top6">
                    <div class="col-sm-6 text-center">欠勤終わり時間</div>
                    <div class="col-sm-6 text-center">
                      {{ $attendancerecord->attendance_date->format("Y年n月j日") . $attendancerecord->leave_end_time }}
                    </div>
                  </div>
                    @if($attendancerecord->leave_check_time && $attendancerecord->mtb_leave_check_status_id == 2)
                  <div id="socool" class="row top6">
                    <div class="col-sm-6 text-center">承認時間</div>
                    <div class="col-sm-6 text-center">
                      {{ $attendancerecord->leave_check_time }}
                    </div>
                  </div>
                  @elseif($attendancerecord->leave_check_time && $attendancerecord->mtb_leave_check_status_id == 3)
                  <div id="socool" class="row top6">
                    <div class="col-sm-6 text-center">断り時間</div>
                    <div class="col-sm-6 text-center">
                      {{ $attendancerecord->leave_check_time }}
                    </div>
                  </div>
                  @endif
                  <div id="socool" class="row top6">
                    <div class="col-sm-6 text-center">休みの理由</div>
                    <div class="col-sm-6 text-center">{{ $attendancerecord->leave_reason}}</div>
                  </div>
                  <div id="socool" class="row top6">
                    <div class="col-sm-6 text-center">欠勤承認状態</div>
                    <div class="col-sm-6 text-center">
                      @if ($attendancerecord->mtb_leave_check_status_id == 3)
                      断り
                      @elseif ($attendancerecord->mtb_leave_check_status_id == 1)
                      未承認
                      @elseif ($attendancerecord->mtb_leave_check_status_id == 2)
                      承認済み
                      @endif
                    </div>
                  </div>
                  <div class="row top36">
                    <div class="col-sm text-center">
                      @if ($errors->any())
                        　<div class="alert alert-danger">
                            　<ul>
                            　    @foreach ($errors->all() as $error)
                                　    <li>{{ $error }}</li>
                              　  @endforeach
                          　  </ul>
                        　</div>
                    　  @endif
                      @if ($attendancerecord->mtb_leave_check_status_id == 1)
                      <div class="row">
                        <div class="col-sm-6 text-right">
                          <form action="{{ route('post_check') }}" method="post">
                            @csrf
                            <input type="hidden" name="mtb_leave_check_status_id" value="{{ $attendancerecord->mtb_leave_check_status_id }}">
                            <input type="hidden" name="act" value="agree">
                            <input type="hidden" name="id" value="{{ $attendancerecord->id }}">
                            <input onclick="return clear1()" type="submit" value="承認">
                          </form>
                        </div>
                        <div class="col-sm-6 text-left">
                          <form action="{{ route('post_check') }}" method="post">
                            @csrf
                            <input type="hidden" name="mtb_leave_check_status_id" value="{{ $attendancerecord->mtb_leave_check_status_id }}">
                            <input type="hidden" name="id" value="{{ $attendancerecord->id }}">
                            <input type="hidden" name="act" value="disagree">
                            <input onclick="return clear2()" type="submit" value="断る">
                          </form>
                        </div>
                      </div>
                      @else
                      @endif
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
  </body>
</html>
