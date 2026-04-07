<div id="chart" style="width: 1500px; height: 400px;"></div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/5.3.2/echarts.min.js" integrity="sha512-weWXHm0Ws2cZKjjwugRMnnOAx9uCP/wUVf84W7/fXQimwYUK28zPDGPprDozomQLpKv6U99xN9PI9+yLI9qxNw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    option = {
        title: {
            text: 'Order per day'
        },
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'shadow'
            }
        },
        legend: {},
        yAxis: {
            type: 'value'
        },
        xAxis: {
            type: 'category',
            data: [
                @foreach ($datas as $data)
                    @if ($loop->last)
                        '{{ $data[0] }}'
                    @else
                        '{{ $data[0] }}',
                    @endif
                @endforeach
            ]
        },
        series: [
            {
                name: 'orders',
                type: 'bar',
                barGap: '0%',
                data: [
                    @foreach ($datas as $data)
                        @if ($loop->last)
                            '{{ $data[1] }}'
                        @else
                            '{{ $data[1] }}',
                        @endif
                    @endforeach
                ],
                itemStyle: {color: 'blue'},
            }
        ]
    };

    var myChart = echarts.init(document.getElementById('chart'));
    myChart.setOption(option);
</script>