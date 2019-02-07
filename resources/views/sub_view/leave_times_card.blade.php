<div class="card">
  <div class="card-header">3ヶ月間の欠勤（予定）回数の棒状チャート図</div>
  <div class="card-body">
    <div id="leave_times" style="width: 550px; height: 400px; margin: 0 auto"></div>
    <script language="JavaScript">
    $(document).ready(function() {
    var chart = {
    type: 'column'
    };
    var title = {
    text: '３ヶ月間の欠勤（予定）回数の棒状チャート図'
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
    headerFormat: '<span style="font-size:10px">{point.key}</span><table style="width:250px">',
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
    var this_month_leave_times = {!! json_encode($this_month_leave_times) !!}
    var next_month_leave_times = {!! json_encode($next_month_leave_times) !!}
    var month_after_next_month_leave_times = {!! json_encode($month_after_next_month_leave_times) !!}
    var series= [
    {
    name: '今月の欠勤（予定）回数',
    data: this_month_leave_times
    },
    {
    name: '来月の欠勤（予定）回数',
    data: next_month_leave_times
    },
    {
    name: '再来月の欠勤（予定）回数',
    data: month_after_next_month_leave_times
    }
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
    $('#leave_times').highcharts(json);

    });
    </script>
  </div>
</div>
