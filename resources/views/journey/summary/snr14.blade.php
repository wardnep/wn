@php
use App\Models\JourneyItem;
@endphp
@php
    $items = JourneyItem::where('journey_id', $select_journey->id)
        ->orderBy('id')
        ->get();

    $total = $items->count();
    $win = $items->where('result_r1', 'WIN')->count();
    $loss = $items->where('result_r1', 'LOSS')->count();

    $win_rate = $total ? $win / $total : 0;
    $loss_rate = 1 - $win_rate;

    // Expectancy
    $exp = ($win_rate * 1.5) - ($loss_rate * 1);

    // Drawdown
    $equity = 0;
    $peak = 0;
    $dd = 0;
    foreach ($items as $item) {
        $r = $item->result_r1 === 'WIN' ? 1.5 : -1;
        $equity += $r;
        $peak = max($peak, $equity);
        $dd = max($dd, $peak - $equity);
    }

    // RF
    $gross_profit = 0;
    $gross_loss = 0;
    foreach ($items as $item) {
        if ($item->result_r1 === 'WIN') {
            $gross_profit += 1.5;
        } else {
            $gross_loss += 1;
        }
    }
    $pf = $gross_loss > 0 ? $gross_profit / $gross_loss : 0;

    // Streak
    $max_losing_streak = 0;
    $current_losing_dtreak = 0;
    foreach ($items as $item) {
        if ($item->result_r1 === 'LOSS') {
            $current_losing_dtreak++;
            $max_losing_streak = max(
                $max_losing_streak,
                $current_losing_dtreak
            );
        } else {
            // เจอ win รีเซ็ต
            $current_losing_dtreak = 0;
        }
    }

    // Recovery Factor
    $net_profit = $equity;
    $rf = $dd > 0 ? $net_profit / $dd : 0;

    // Order / Day
    $date_count = JourneyItem::where('journey_id', $select_journey->id)->distinct('date')->count();
    $obd = number_format($date_count / $total, 2);
@endphp
<div class="row">
    <div class="col-md-2">
        Total <b>{{ $total }}</b>
    </div>
    <div class="col-md-2">
        Win Rate <b>{{ number_format($win_rate, 2) }}%</b>
    </div>
    <div class="col-md-2">
        Losing Streak <b>{{ $max_losing_streak }}</b>
    </div>
    <div class="col-md-3">
        Win <b>{{ $win }}</b> Loss <b>{{ $loss }}</b>
    </div>
    <div class="col-md-2">
        Orders/Day <b>{{ $obd }}</b>
    </div>
    <div class="col-md-2">
        Expectancy <b>{{ number_format($exp, 2) }}</b>
    </div>
    <div class="col-md-2">
        DD <b>{{ $dd }}R</b>
    </div>
    <div class="col-md-2">
        Profit Factor <b>{{ number_format($pf, 2) }}</b>
    </div>
    <div class="col-md-3">
        Recovery Factor <b>{{ number_format($rf, 2) }}</b>
    </div>
    <div class="col-md-2">
        <a href="{{ url('journey/download/'.$select_journey->id) }}"><span class="fa fa-file-excel-o" /> Export</a>
    </div>
</div>
