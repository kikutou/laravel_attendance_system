<div class="card">
  <div class="card-header">今月の出勤時間の棒状チャート図</div>
  <div class="card-body">
    <div id="attendance" style="width: 550px; height: 400px; margin: 0 auto"></div>
    <input type="hidden">
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
   var user_names = {!! json_encode($user_names) !!};
   var xAxis = {
      categories:user_names,
      crosshair: true
   };
   var yAxis = {
      min: 0,
      max:30,
      title: {
         text: '回数(1-30回)'
      },
      labels: {
        formatter:function(){
          return this.value+'回';
      }
    }
   };
   var tooltip = {
      headerFormat: '<span style="font-size:10px">{point.key}</span><table style="width:100px">',
      pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                   '<td style="padding:0"><b>{point.y}</b></td></tr>',
      footerFormat: '</table>',
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
   var late_times = {!! json_encode($late_times) !!}
   var series= [{
            name: '遅刻回数',
            data: late_times
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
   $('#attendance').highcharts(json);

  });
  </script>
  </div>
</div>
