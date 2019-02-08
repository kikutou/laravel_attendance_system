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
      text: '{{ Auth::user()->name }} 今月の出勤時間の棒状チャート図'
   };
   var subtitle = {
      text: '勤怠管理システム'
   };
   var days = {!! json_encode($days) !!}
   var xAxis = {
       type:'datetime',
       title: {
          text: '日付(最近の一か月)'
       },
      categories:days,
      crosshair: true
   };
   var yAxis = {
       type:'datetime',
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
     /*formatter: function(){
         var h = parseInt(this.y) < 10 ? "0" + parseInt(this.y) : parseInt(this.y);
         var m = (this.y-parseInt(this.y))*60 < 10 ? "0" + Math.round((this.y-parseInt(this.y))*60) : Math.round((this.y-parseInt(this.y))*60);
         return this.x+'<br/>'+this.series.name+'<br/>'+h+':'+ m;
       }*/
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
    /*  {
        name:'出勤時間',
        data:start_time
      },
      {
        name:'退勤時間',
        data:end_time
      }*/
    ];

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
   $('#user_attendance_card').highcharts(json);

  });
  </script>
  </div>
</div>
