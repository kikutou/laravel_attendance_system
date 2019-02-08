<div class="card">
    <div class="card-header">今月の出勤時間の棒状チャート図</div>
    <div class="card-body">
      <div id="user_attendance" style="width: 550px; height: 400px; margin: 0 auto"></div>
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
            var days = {!! json_encode($days) !!}
            var xAxis = {
              title: {
                 text: '日付(最近の一か月)'
              },
              labels:{
                rotation:-30
              },
              categories: days,
              crosshair: true
            };
            var yAxis = {
               title: {
                  text: '時間(0:00-20:00)'
               },
               labels: {
                 formatter:function(){
                   return this.value + ':00';
               }
             }

            };
            var tooltip = {
               headerFormat: '<span style="font-size:10px">{point.key}</span><table style="width:100px">',
               pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>'+
                            '<tr><td style="padding:0"><b>{point.hour}時{point.minute}分</b></td></tr>',
               shared: true,
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

            var start_time = {!! json_encode($start_time) !!}
            var end_time = {!! json_encode($end_time) !!}
            var series= [
               {
                 name:'出勤時間',
                 data:[{hour:12,minute:0,y:12}]
               },
               {
                 name:'退勤時間',
                 data:end_time
               }

             ];
            for(var i = 0;i < start_time.length;i++){
              series[0].data[i].y = 1,
            };
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
            $('#user_attendance').highcharts(json);

          });
        </script>
    </div>
</div>
