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

          var yAxis = {
             min: 0,
             // max: 20,
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
             formatter: function(){
               var data = this.y.toString().split('.');
               var h = data[0];
               var m = data[1] ? data[1] : '00';
               // console.log(this.point);
               return this.point.name+'<br/>'+this.series.name+'<br/>'+h+':'+m;
             }
             // headerFormat: '<span style="font-size:10px">{point.key}</span>',
             // pointFormat: '<tr><td style="padding:0"><b>{point.v}時</b></td></tr>',
             // shared: false,
             // useHTML: true,
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
                        @if (in_array(\Carbon\Carbon::now()->subMonth(1)->addDays($i)->format('Y-m-d'), $t_date))
                          @php
                            $pos = array_search(\Carbon\Carbon::now()->subMonth(1)->addDays($i)->format('Y-m-d'), $t_date);
                            $timeArr = explode(":", $atts[$pos]['start_time']);
                            $h = $timeArr[0];
                            $m = $timeArr[1];
                            $start_time = $h.'.'.$m;
                            // dd($start_time);
                          @endphp
                          ['{{ \Carbon\Carbon::now()->subMonth(1)->addDays($i)->format("m-d") }}', {{ $start_time }}],
                        @else
                          ['{{ \Carbon\Carbon::now()->subMonth(1)->addDays($i)->format("m-d") }}', 0],
                        @endif
                    @endfor
                   ]
                 }, {
            name: '退勤時間',
            data: [
              @for ($i = 1; $i <= 30; $i++)
                 @if (in_array(\Carbon\Carbon::now()->subMonth(1)->addDays($i)->format('Y-m-d'), $t_date))
                   @php
                     $pos = array_search(\Carbon\Carbon::now()->subMonth(1)->addDays($i)->format('Y-m-d'), $t_date);
                     $timeArr = explode(":", $atts[$pos]['end_time']);
                     $h = $timeArr[0];
                     $m = $timeArr[1];
                     $end_time = $h.'.'.$m;
                     // dd($start_time);
                   @endphp
                   ['{{ \Carbon\Carbon::now()->subMonth(1)->addDays($i)->format("m-d") }}', {{ $end_time }}],
                 @else
                   ['{{ \Carbon\Carbon::now()->subMonth(1)->addDays($i)->format("m-d") }}', 0],
                 @endif
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
