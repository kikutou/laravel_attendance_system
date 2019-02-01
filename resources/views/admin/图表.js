var chart = Highcharts.chart('container',{
	chart: {
		type: 'column'
	},
	title: {
		text: '最近30天出勤情况'
	},
	subtitle: {
		text: '数据来源: 内部用户考勤系统'
	},
	xAxis: {
		categories: [
			// 这里循环用户
			'张三','李四','王五'
		],
		crosshair: true,
		labels:{
			rotation: -30
		}
	},
	legend:{
		enabled:false	
	},
	credits:{
		enabled: false
	},
	yAxis: {
		min: 0,
		title: {
			text: '出勤天数 (天)'
		}
	},
	tooltip: {
		headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
		pointFormat: '<tr><td style="color:{series.color};padding:0">出勤: </td>' +
		'<td style="padding:0"><b>{point.y} 天</b></td></tr>',
		footerFormat: '</table>',
		shared: true,
		useHTML: true
	},
	plotOptions: {
		column: {
			borderWidth: 0
		}
	},
	series: [{
		// data 里循环放各个用户的出勤天数
		data: [30, 25, 15]
	}]
});