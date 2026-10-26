@extends('_layouts.app')

@section('title')
	{{ $journey->name }} - Summary Chart
@endsection

@section('content')
    <section class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
						<div id="chart1" style="width: 1500px; height: 400px;"></div>
						<div id="chart2" style="width: 1500px; height: 400px;"></div>
						<div id="chart3" style="width: 1500px; height: 400px;"></div>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection

@section('js')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/5.3.2/echarts.min.js" integrity="sha512-weWXHm0Ws2cZKjjwugRMnnOAx9uCP/wUVf84W7/fXQimwYUK28zPDGPprDozomQLpKv6U99xN9PI9+yLI9qxNw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script>
		// สีสำหรับ dark theme
		var textColor = '#e5e7eb';
		var mutedColor = '#9ca3af';
		var gridColor = 'rgba(255, 255, 255, 0.15)';
		var lineColor = '#60a5fa';

		var option1 = {
			backgroundColor: 'transparent',
			title: {
				text: "{{ $r }}R - {{ $items->count() }} trades",
				textStyle: { color: textColor }
			},
			tooltip: {
				trigger: 'axis',
				formatter: function (params) {
					let data = params[0];
					return `<b>${data.value.toLocaleString()}</b>`;
				}
			},
			grid: {
				left: '1%',
				right: '1%',
				bottom: '3%',
				containLabel: true
			},
			xAxis: {
				type: 'category',
				data: [
					@php
						$total = $items->count();
						$prev_month = "";
					@endphp
					@foreach ($items as $key => $item)
						@php
							$dates = explode(' ', $item->date);
							$current_month = $dates[1];
						@endphp
						@if ($key == 0 || $key == $total - 1 || $prev_month != $current_month)
							'{{ $item->date }}',
						@else
							'',
						@endif
						@php
							$prev_month = $current_month;
						@endphp
					@endforeach
				],
				boundaryGap: false,
				axisLabel: {
					rotate: 90,
					interval: 0,
					color: textColor
				},
				axisLine: { lineStyle: { color: mutedColor } },
				axisTick: { lineStyle: { color: mutedColor } }
			},
			yAxis: {
				type: 'value',
				axisLabel: { color: textColor },
				axisLine: { show: true, lineStyle: { color: mutedColor } },
				splitLine: { lineStyle: { color: gridColor } }
			},
			series: [
				{
					symbol: 'R',
					data: [
						@php
							$profit = 0;
						@endphp
						@foreach ($items as $item)
						@php
							if ($item->result_r1 === 'WIN') {
								$profit += 2;
							} else {
								$profit -= 1;
							}
						@endphp
							{{ $profit }}{{ !$loop->last ? ',' : '' }}
						@endforeach
					],
					type: 'line',
					lineStyle: { color: lineColor, width: 2 },
					itemStyle: { color: lineColor }
				}
			]
		};

		var option2 = {
			backgroundColor: 'transparent',
			title: {
				text: "Win Rate",
				textStyle: { color: textColor }
			},
			tooltip: {
				trigger: 'axis',
				formatter: function (params) {
					let data = params[0];
					return `<b>${data.value.toLocaleString()}</b>`;
				}
			},
			grid: {
				left: '1%',
				right: '1%',
				bottom: '3%',
				containLabel: true
			},
			xAxis: {
				type: 'category',
				data: [
					@php
						$total = $items->count();
						$prev_month = "";
					@endphp
					@foreach ($items as $key => $item)
						@php
							$dates = explode(' ', $item->date);
							$current_month = $dates[1];
						@endphp
						@if ($key == 0 || $key == $total - 1 || $prev_month != $current_month)
							'{{ $item->date }}',
						@else
							'',
						@endif
						@php
							$prev_month = $current_month;
						@endphp
					@endforeach
				],
				boundaryGap: false,
				axisLabel: {
					rotate: 90,
					interval: 0,
					color: textColor
				},
				axisLine: { lineStyle: { color: mutedColor } },
				axisTick: { lineStyle: { color: mutedColor } }
			},
			yAxis: {
				type: 'value',
				axisLabel: { color: textColor },
				axisLine: { show: true, lineStyle: { color: mutedColor } },
				splitLine: { lineStyle: { color: gridColor } }
			},
			series: [
				{
					symbol: '%',
					data: [
						@foreach ($win_rate as $item)
							{{ $item }}{{ !$loop->last ? ',' : '' }}
						@endforeach
					],
					type: 'line',
					lineStyle: { color: lineColor, width: 2 },
					itemStyle: { color: lineColor }
				}
			]
		};

		var option3 = {
			backgroundColor: 'transparent',
			title: {
				text: "|Win - Loss|",
				textStyle: { color: textColor }
			},
			tooltip: {
				trigger: 'axis',
				formatter: function (params) {
					let data = params[0];
					return `<b>${data.value.toLocaleString()}</b>`;
				}
			},
			grid: {
				left: '1%',
				right: '1%',
				bottom: '3%',
				containLabel: true
			},
			xAxis: {
				type: 'category',
				data: [
					@php
						$total = $items->count();
						$prev_month = "";
					@endphp
					@foreach ($items as $key => $item)
						@php
							$dates = explode(' ', $item->date);
							$current_month = $dates[1];
						@endphp
						@if ($key == 0 || $key == $total - 1 || $prev_month != $current_month)
							'{{ $item->date }}',
						@else
							'',
						@endif
						@php
							$prev_month = $current_month;
						@endphp
					@endforeach
				],
				boundaryGap: false,
				axisLabel: {
					rotate: 90,
					interval: 0,
					color: textColor
				},
				axisLine: { lineStyle: { color: mutedColor } },
				axisTick: { lineStyle: { color: mutedColor } }
			},
			yAxis: {
				type: 'value',
				axisLabel: { color: textColor },
				axisLine: { show: true, lineStyle: { color: mutedColor } },
				splitLine: { lineStyle: { color: gridColor } }
			},
			series: [
				{
					symbol: 'R',
					data: [
						@foreach ($win_loss as $item)
							{{ $item }}{{ !$loop->last ? ',' : '' }}
						@endforeach
					],
					type: 'line',
					lineStyle: { color: lineColor, width: 2 },
					itemStyle: { color: lineColor }
				}
			]
		};

		var myChart1 = echarts.init(document.getElementById('chart1'), 'dark');
		myChart1.setOption(option1);

		var myChart2 = echarts.init(document.getElementById('chart2'), 'dark');
		myChart2.setOption(option2);

		var myChart3 = echarts.init(document.getElementById('chart3'), 'dark');
		myChart3.setOption(option3);
	</script>
@endsection