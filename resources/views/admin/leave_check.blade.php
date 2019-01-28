<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/4.1.0/css/bootstrap.min.css">
    <script src="https://cdn.staticfile.org/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/popper.js/1.12.5/umd/popper.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/4.1.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.staticfile.org/jquery/1.10.2/jquery.min.js"></script>


    <!-- 自分のcss -->
    <link rel="stylesheet" href="{{asset('/css/layout.css')}}">
    <link rel="stylesheet" href="{{asset('/css/div.css')}}">

    <title></title>
    <style>
      div.current {
        background: gray;
      }
      .margin{
        margin-left: 270px;
      }
      body{
        overflow: scroll;
      }
      .cool{
        margin-left:260px;
      }

      #socool{
        margin-top:10px;
      }

      #top{
        margin-top: 20px;
      }

      .top1{
        border: 5px solid gray;
      }
    </style>
    <script type="text/javascript">
      function clear1()
      {
       if(confirm("承認をしますか？"))
       {
       return true;
     }else {
       return false;
     }
      }
    </script>
    <script type="text/javascript">
      function clear2()
      {
       if(confirm("断りをしますか？"))
       {
       return true;
     }else{
       return false;
     }
      }
    </script>

  </head>

  <body>
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
                    <div class="col-sm-6 text-center">{{ $attendancerecord->user->name }}</div>
                  </div>
                  <div id="socool" class="row top6">
                    <div class="col-sm-6 text-center">欠勤開始時間</div>
                    <div class="col-sm-6 text-center">
                      {{ $attendancerecord->attendace_date->format("Y年n月j日") . $attendancerecord->leave_start_time }}
                    </div>
                  </div>
                  <div id="socool" class="row top6">
                    <div class="col-sm-6 text-center">欠勤終わり時間</div>
                    <div class="col-sm-6 text-center">
                      {{ $attendancerecord->attendace_date->format("Y年n月j日") . $attendancerecord->leave_end_time }}
                    </div>
                  </div>
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
                            <input onclick="return clear1()" type="submit" value="承認">
                          </form>
                        </div>
                        <div class="col-sm-6 text-left">
                          <form action="{{ route('post_check') }}" method="post">
                            @csrf
                            <input type="hidden" name="mtb_leave_check_status_id" value="{{ $attendancerecord->mtb_leave_check_status_id }}">
                            <input type="hidden" name="act" value="disagree">
                            <input onclick="return clear2()" type="submit" value="断る">
                          </form>
                        </div>
                      </div>
                      @else
                        操作不可
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
