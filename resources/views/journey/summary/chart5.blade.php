<div id="chart" style="width: 1500px; height: 400px;"></div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/5.3.2/echarts.min.js" integrity="sha512-weWXHm0Ws2cZKjjwugRMnnOAx9uCP/wUVf84W7/fXQimwYUK28zPDGPprDozomQLpKv6U99xN9PI9+yLI9qxNw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    var option = {
		title: {
            text: 'R'
        },
		tooltip: {
			trigger: 'axis',
			formatter: function (params) {
				let data = params[0];
				return `<b>${data.value.toLocaleString()}</b>`;
			}
		},
		grid: {
			left: '0%',
			right: '0%',
			bottom: '3%',
			containLabel: true
		},
        xAxis: {
			type: 'category',
			data: [
				@php
					$prev_month = "";
				@endphp
				@foreach ($items as $item)
				@php
					$month = explode(" ", $item->date)[1];
				@endphp
                    @if ($loop->first)
                        '{{ $item->date }}',
                    @elseif ($loop->last)
                        '{{ $item->date }}'
                    @else
                        @if ($month !== $prev_month)
							'{{ $month }}',
						@else
							'',
						@endif
                    @endif
				@php
					$prev_month = $month;
				@endphp
                @endforeach
			],
			boundaryGap: false,
			axisLabel: {
                rotate: 60,
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
						$profit += $item->result_r1;
					@endphp
					{{ $profit }}{{ !$loop->last ? ',' : '' }}
					@endforeach
				],
				type: 'line'
			}
		]
    };

    var myChart = echarts.init(document.getElementById('chart'));
    myChart.setOption(option);
</script>
