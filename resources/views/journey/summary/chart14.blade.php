<div id="chart1" style="width: 1500px; height: 400px;"></div>
<div id="chart2" style="width: 1500px; height: 400px;"></div>
<div id="chart3" style="width: 1500px; height: 400px;"></div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/5.3.2/echarts.min.js" integrity="sha512-weWXHm0Ws2cZKjjwugRMnnOAx9uCP/wUVf84W7/fXQimwYUK28zPDGPprDozomQLpKv6U99xN9PI9+yLI9qxNw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    var option1 = {
		title: {
            text: "{{ $r }}R - {{ $items->count() }} trades"
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
                interval: 0
            }
		},
		yAxis: {
			type: 'value'
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
							$profit += 1.5;
						} else {
							$profit -= 1;
						}
					@endphp
						{{ $profit }}{{ !$loop->last ? ',' : '' }}
					@endforeach
				],
				type: 'line'
			}
		]
    };

	var option2 = {
		title: {
            text: "Win Rate"
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
                interval: 0
            }
		},
		yAxis: {
			type: 'value'
		},
		series: [
			{
				symbol: '%',
				data: [
					@foreach ($win_rate as $item)
						{{ $item }}{{ !$loop->last ? ',' : '' }}
					@endforeach
				],
				type: 'line'
			}
		]
    };

	var option3 = {
		title: {
            text: "Win - Loss"
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
                interval: 0
            }
		},
		yAxis: {
			type: 'value'
		},
		series: [
			{
				symbol: 'R',
				data: [
					@foreach ($win_loss as $item)
						{{ $item }}{{ !$loop->last ? ',' : '' }}
					@endforeach
				],
				type: 'line'
			}
		]
    };

    var myChart1 = echarts.init(document.getElementById('chart1'));
    myChart1.setOption(option1);

	var myChart2 = echarts.init(document.getElementById('chart2'));
    myChart2.setOption(option2);

	var myChart3 = echarts.init(document.getElementById('chart3'));
    myChart3.setOption(option3);
</script>
