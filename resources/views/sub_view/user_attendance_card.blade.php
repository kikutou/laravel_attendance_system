<div class="card">
  <div class="card-header">今月の出勤時間の棒状チャート図</div>
  <div class="card-body">
    <div id="user_attendance_card" style="width: 550px; height: 400px; margin: 0 auto"></div>
    <script language="JavaScript">
        $(document).ready(function() {
          var chart = {
              type: 'column'
          };
          var title = {
              text: '従業員今月の遅刻回数の棒状チャート図'
          };
          var subtitle = {
              text: '勤怠管理システム'
          };
          var xAxis = {
            title: {
                text: '名前'
            },
            categories: [
              @foreach($users as $user)
                '{{ $user->name }}',
              @endforeach
            ],
            crosshair: true
          };
          var yAxis = {
              min: 0,
              max: 30,
              title: {
                text: '回数(1-30回)'
              },
              labels: {
                formatter:function(){
                  return this.value+':次';
              }
            }
          };
          var tooltip = {
            formatter: function(){
              return this.point.category+'<br/><span style="font-size:20px">'+this.y+'次</span>';
            }

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
                    data: [
                      @foreach($atts as $att)
                          {{$att->top}},
                      @endforeach
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
