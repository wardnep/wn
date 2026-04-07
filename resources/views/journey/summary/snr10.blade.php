@php
use App\Models\JourneyItem;
@endphp
@php
    $items = JourneyItem::where('journey_id', $select_journey->id)
        // ->where('entry_session', '<>', 'London')
        ->orderBy('id')
        ->get();

    $total = $items->count();

    $win = $items->where('result_r1', '>', 0)->count();
    $loss = $items->where('result_r1', '<', 0)->count();
    $be = $items->where('result_r1', 0)->count();

    $win_rate = $total ? ($win / $total) * 100 : 0;
    $loss_rate = 100 - $win_rate;

    // Expectancy
    $exp = $total ? $items->sum('result_r1') / $total : 0;

    // Drawdown
    $equity = 0;
    $peak = 0;
    $dd = 0;

    foreach ($items as $item) {
        $equity += $item->result_r1;
        $peak = max($peak, $equity);
        $dd = max($dd, $peak - $equity);
    }

    // PF
    $gross_profit = $items->where('result_r1', '>', 0)->sum('result_r1');
    $gross_loss = abs($items->where('result_r1', '<', 0)->sum('result_r1'));
    $pf = $gross_loss > 0 ? $gross_profit / $gross_loss : 0;

    // RF
    $net_profit = $items->sum('result_r1');
    $rf = $dd > 0 ? $net_profit / $dd : 0;

    // Streak
    $winning_streak = 0;
    $losing_streak = 0;
    $win_count = 0;
    $loss_count = 0;
    foreach ($items as $item) {

        if ($item->result_r1 > 0) {
            $win_count++;
            $loss_count = 0;

        } elseif ($item->result_r1 < 0) {
            $loss_count++;
            $win_count = 0;

        } else {
            // BE → reset (สำคัญ)
            // $win_count = 0;
            // $loss_count = 0;
        }

        $winning_streak = max($winning_streak, $win_count);
        $losing_streak = max($losing_streak, $loss_count);
    }

    // Order / Day
    $start_date = $items->first() ? date2MySqlDate2($items->first()->date) : '';
    $last_date = $items->first() ? date2MySqlDate2($items->sortByDesc('id')->first()->date) : '';
    $start = Carbon::parse($start_date);
    $end = Carbon::parse($last_date);
    $weekdays = $start->diffInWeekdays($end);
    $obd = $weekdays ? number_format($total / $weekdays, 2) : 0;
@endphp
{{-- <h4> --}}
<div class="row">
    <div class="col-md-2">
        Total <b>{{ $total }}</b>
    </div>
    <div class="col-md-2">
        Win Rate <b>{{ number_format($win_rate, 2) }}%</b>
    </div>
    <div class="col-md-2">
        Losing Streak <b>{{ $losing_streak }}</b>
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
{{-- </h4> --}}
