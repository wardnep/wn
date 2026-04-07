@php
use App\JourneyItem;
@endphp
@php
    $items = JourneyItem::where('journey_id', $select_journey->id)->get();

    $total = $items->count();
    $win = $items->where('result', 'WIN')->count();
    $loss = $items->where('result', 'LOSS')->count();
    $win_point = $items->where('result', 'WIN')->sum('tp1');
    $loss_point = $items->where('result', 'LOSS')->sum('tp1');

    $win_rate = $total ? ($win / $total) * 100 : 0;
    $loss_rate = $total ? 100 - $win_rate : 0;

    // dd($win_rate, $loss_rate, ($win_rate * 2), ($loss_rate * 1), ($win_rate * 2) - ($loss_rate * 1));

    $winning_streak = 0;
    $losing_streak = 0;
    $win_count = 0;
    $loss_count = 0;
    //
    $prev_date = '';
    $order_date_count = 0;
    foreach ($items as $item) {
        if ($item->result == 'WIN') {
            $win_count++;
            $loss_count = 0;
        } else if ($item->result == 'LOSS') {
            $win_count = 0;
            $loss_count++;
        }

        if ($win_count > $winning_streak) {
            $winning_streak = $win_count;
        }

        if ($loss_count > $losing_streak) {
            $losing_streak = $loss_count;
        }
        //////
        //////
        //////
        if ($prev_date != $item->date) {
            $order_date_count++;
        }
        $prev_date = $item->date;
    }

    function drawdown($items)
    {
        $equity = 0;
        $peak = 0;
        $maxDD = 0;

        foreach ($items as $item) {
            if ($item->result == 'WIN') {
                $equity += 2;
            } else if ($item->result == 'LOSS') {
                $equity -= 1;
            }

            if ($equity > $peak) {
                $peak = $equity;
            }

            $dd = $peak - $equity;
            if ($dd > $maxDD) {
                $maxDD = $dd;
            }
        }

        return $maxDD;
    }

    function expectancy($items)
    {
        $total = $items->count();

        $win = $items->where('result', 'WIN')->count();
        $loss = $items->where('result', 'LOSS')->count();

        $win_rate = $total ? ($win / $total) * 100 : 0;
        $loss_rate = $total ? 100 - $win_rate : 0;

        return number_format((($win_rate * 2) - ($loss_rate * 1)) / 100, 2);
    }

    $all_exp =  expectancy($items);
    $asia_exp = expectancy($items->where('session', 'Asia'));
    $london_exp = expectancy($items->where('session', 'London'));
    $london_ny_exp = expectancy($items->where('session', 'London + NY'));
    $ny_exp = expectancy($items->where('session', 'NY'));

    $all_dd =  drawdown($items);
    $asia_dd = drawdown($items->where('session', 'Asia'));
    $london_dd = drawdown($items->where('session', 'London'));
    $london_ny_dd = drawdown($items->where('session', 'London + NY'));
    $ny_dd = drawdown($items->where('session', 'NY'));

    // dd($loss, $all_dd);

    $pf = $loss ? ($win * 2) / $loss : 0;
    $rf = $all_dd ? (($win * 2) - $loss) / $all_dd : 0;

    $obd = $order_date_count ? $total / $order_date_count : 0;
@endphp
<h4>
<div class="row">
    <div class="col-md-3">
        Total <b>{{ $total }}</b><br />
        Win <b>{{ $win }}</b> Loss <b>{{ $loss }}</b> Point <b>{{ $win_point - $loss_point }}</b><br />
        Win Rate <b>{{ number_format($win_rate, 2) }}%</b><br />
        Winning/Losing Streak <b>{{ $winning_streak }}</b>/<b>{{ $losing_streak }}</b><br />
        Orders/Day <b>{{ number_format($obd, 2) }}</b><br />
        <a href="{{ url('journey/chart/'.$select_journey->id) }}" target="_blank">chart</a>
    </div>
    <div class="col-md-3">
        Expectancy <b>{{ $all_exp }}R</b><br />
        Asia <b>{{ $asia_exp }}R</b><br />
        London <b>{{ $london_exp }}R</b><br />
        London + NY <b>{{ $london_ny_exp }}R</b><br />
        NY <b>{{ $ny_exp }}R</b>
    </div>
    <div class="col-md-3">
        Max DD <b>{{ $all_dd }}R</b><br />
        Asia <b>{{ $asia_dd }}R</b><br />
        London <b>{{ $london_dd }}R</b><br />
        London + NY <b>{{ $london_ny_dd }}R</b><br />
        NY <b>{{ $ny_dd }}R</b>
    </div>
    <div class="col-md-3">
        Profit Factor <b>{{ number_format($pf, 2) }}</b><br />
        Recovery Factor <b>{{ number_format($rf, 2) }}</b>
    </div>
</div>
</h4>
