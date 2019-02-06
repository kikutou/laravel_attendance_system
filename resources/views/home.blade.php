@extends('layouts.app')
@section("title","ホーム")
@section('content')

    <style>
        main div.container {
            margin-bottom: 20px;
        }
    </style>
    @if(!Auth::user()->admin_flg)
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    @include("sub_view.info_card", ["infos" => Auth::user()->get_all_unread_infos()])
                </div>
            </div>
        </div>


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">名前:{{ Auth::user()->name }}</div>
                    <div class="card-body">
                      <ul>
                        <li class="list-group-item">日付&nbsp:&nbsp{{ $today->format('Y年m月d日')}}</li>
                        <li class="list-group-item">今月の遅刻回数&nbsp:&nbsp{{$late}}</li>
                        <li class="list-group-item">今月の欠勤回数&nbsp:&nbsp{{$leave}}</li>
                      </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">今月の出勤時間の棒状チャート図</div>
                    <div class="card-body">
                      <div id="container" style="width: 550px; height: 400px; margin: 0 auto"></div>
                        <script language="JavaScript">
                          $(document).ready(function() {
                            var chart = {
                               type: 'column'
                            };
                            var title = {
                               text: '{{ Auth::user()->name }} 今月の出勤時間の棒状チャート図'
                            };
                            var subtitle = {
                               text: '勤怠管理システム'
                            };
                            var xAxis = {
                              type:'category',
                              title: {
                                 text: '日付(最近の一か月)'
                              },
                              labels:{
                                rotation:-30
                              }
                            };
                           //  var xAxis = {
                           //
                           //    title: {
                           //       text: '日付(最近の一か月)'
                           //    },
                           //    labels:{
                           //      rotation:-30
                           //    },
                           //    categories: [
                           //      @for ($i = 1; $i <= 30; $i++)
                           //       @foreach ($atts as $val)
                           //         @if (date("Y-m-d", strtotime($val->attendance_date)) == \Carbon\Carbon::now()->subMonth(1)->addDays($i)->format('Y-m-d'))
                           //           ['date("m-d", strtotime($val->attendance_date'],
                           //         @else
                           //           ['{{ \Carbon\Carbon::now()->subMonth(1)->addDays($i)->format('m-d') }}'],
                           //         @endif
                           //       @endforeach
                           //     @endfor
                           //    ],
                           //    crosshair: true
                           // };
                            var yAxis = {
                               min: 0,
                               max: 20,
                               title: {
                                  text: '時間(0:00-20:00)'
                               },
                               labels: {
                                 formatter:function(){
                                   return this.value+':00';
                               }
                             }

                            };
                            var tooltip = {
                               headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                               pointFormat: '<tr><td style="padding:0"><b>{point.y}時</b></td></tr>',
                               shared: false,
                               useHTML: true
                            };
                            var plotOptions = {
                               column: {
                                  pointPadding: 0.2,
                                  borderWidth: 0
                               }
                            };
                            var credits = {
                               enabled: false
                            };

                            var series= [{
                              name: '出勤時間',
                                     data: [
                                       @for ($i = 1; $i <= 30; $i++)
                                        @foreach ($atts as $val)
                                          @if (date("Y-m-d", strtotime($val->attendance_date)) == \Carbon\Carbon::now()->subMonth(1)->addDays($i)->format('Y-m-d'))
                                            @php
                                            if (!empty($val->start_time)) {
                                              // 10:00:00
                                              $start_time_pos = strpos($val->start_time, ":");
                                              $start_time = substr($val->start_time, 0, $start_time_pos);
                                            } else {
                                              $start_time = 0;
                                            }
                                            @endphp
                                            ['{{ \Carbon\Carbon::now()->subMonth(1)->addDays($i)->format('m-d') }}', {{ $start_time }}],
                                          @else
                                            ['{{ \Carbon\Carbon::now()->subMonth(1)->addDays($i)->format('m-d') }}', 0],
                                          @endif
                                        @endforeach
                                      @endfor
                                     ]
                                   }, {
                              name: '退勤時間',
                              data: [
                                @for ($i = 1; $i <= 30; $i++)
                                 @foreach ($atts as $val)
                                   @if (date("Y-m-d", strtotime($val->attendance_date)) == \Carbon\Carbon::now()->subMonth(1)->addDays($i)->format('Y-m-d'))
                                     @php
                                     if (!empty($val->end_time)) {
                                       // 10:00:00
                                       $start_time_pos = strpos($val->end_time, ":");
                                       $end_time = substr($val->end_time, 0, $start_time_pos);
                                     } else {
                                       $end_time = 0;
                                     }
                                     @endphp
                                     ['{{ \Carbon\Carbon::now()->subMonth(1)->addDays($i)->format('m-d') }}', {{ $end_time }}],
                                   @else
                                     ['{{ \Carbon\Carbon::now()->subMonth(1)->addDays($i)->format('m-d') }}', 0],
                                   @endif
                                 @endforeach
                               @endfor
                              ]
                               }];
                            var json = {};
                            json.chart = chart;
                            json.title = title;
                            json.subtitle = subtitle;
                            json.tooltip = tooltip;
                            json.xAxis = xAxis;
                            json.yAxis = yAxis;
                            json.series = series;
                            json.plotOptions = plotOptions;
                            json.credits = credits;
                            $('#container').highcharts(json);

                          });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif


@endsection
