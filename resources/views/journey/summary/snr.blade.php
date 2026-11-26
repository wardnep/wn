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
    $expectancy = ($win_rate * $select_journey->rr) - ($loss_rate * 1);

    // Drawdown
    $equity = 0;
    $peak = 0;
    $dd = 0;
    // RF
    $gross_profit = 0;
    $gross_loss = 0;
    // Streak
    $max_losing_streak = 0;
    $current_losing_streak = 0;
    foreach ($items as $item) {
        //
        //
        // Drawdown
        //
        $r = $item->result_r1 === 'WIN' ? $select_journey->rr : -1;
        $equity += $r;
        $peak = max($peak, $equity);
        $dd = max($dd, $peak - $equity);
        //
        //
        // RF
        //
        if ($item->result_r1 === 'WIN') {
            $gross_profit += $select_journey->rr;
        } else {
            $gross_loss += 1;
        }
        //
        //
        // Streak
        //
        if ($item->result_r1 === 'LOSS') {
            $current_losing_streak++;
            $max_losing_streak = max(
                $max_losing_streak,
                $current_losing_streak
            );
        } else {
            // เจอ win รีเซ็ต
            $current_losing_streak = 0;
        }
    }

    $pf = $gross_loss > 0 ? $gross_profit / $gross_loss : 0;

    // Recovery Factor
    $net_profit = $equity;
    $rf = $dd > 0 ? $net_profit / $dd : 0;

    // Order / Day
    if ($items->first()) {
        $start = Carbon::createFromFormat('d M Y', $items->first()->date);
        $end   = Carbon::createFromFormat('d M Y', $items->last()->date);
        $date_count = $start->diffInWeekdays($end) + ($start->isWeekday() ? 1 : 0);
        $obd = $date_count > 0 ? number_format($total / $date_count, 2) : 0;
    } else {
        $obd = 0;
    }

    // Color metrics from red (weak) through yellow to green (strong).
    $metricColor = function ($value, $good, $bad) {
        if ($good == $bad) {
            $score = 0;
        } elseif ($good > $bad) {
            $score = ($value - $bad) / ($good - $bad);
        } else {
            $score = ($bad - $value) / ($bad - $good);
        }
        $score = max(0, min(1, $score));
        $red = [248, 113, 113];
        $yellow = [250, 204, 21];
        $green = [74, 222, 128];
        $from = $score < 0.5 ? $red : $yellow;
        $to = $score < 0.5 ? $yellow : $green;
        $ratio = ($score < 0.5 ? $score : $score - 0.5) * 2;
        $rgb = [];
        for ($i = 0; $i < 3; $i++) {
            $rgb[] = (int) round($from[$i] + ($to[$i] - $from[$i]) * $ratio);
        }

        return sprintf('#%02x%02x%02x', $rgb[0], $rgb[1], $rgb[2]);
    };
@endphp
<div class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-5">
    <div class="rounded-lg border border-gray-700 bg-gray-800 p-3">Total <b class="ml-1 text-white">{{ $total }}</b></div>
    <div class="rounded-lg border border-gray-700 bg-gray-800 p-3">Win Rate <b class="ml-1" style="color: {{ $metricColor($win_rate * 100, 60, 30) }}">{{ number_format($win_rate * 100, 2) }}%</b></div>
    <div class="rounded-lg border border-gray-700 bg-gray-800 p-3">Losing Streak <b class="ml-1" style="color: {{ $metricColor($max_losing_streak, 1, 6) }}">{{ $max_losing_streak }}</b></div>
    <div class="rounded-lg border border-gray-700 bg-gray-800 p-3">Win <b class="text-emerald-400">{{ $win }}</b> <span class="text-gray-500">/</span> Loss <b class="text-rose-400">{{ $loss }}</b></div>
    <div class="rounded-lg border border-gray-700 bg-gray-800 p-3">Orders/Day <b class="ml-1 text-white">{{ $obd }}</b></div>
    <div class="rounded-lg border border-gray-700 bg-gray-800 p-3">Expectancy <b class="ml-1" style="color: {{ $metricColor($expectancy, 1, 0) }}">{{ number_format($expectancy, 2) }}</b></div>
    <div class="rounded-lg border border-gray-700 bg-gray-800 p-3">DD <b class="ml-1" style="color: {{ $metricColor($dd, 0, 10) }}">{{ $dd }}R</b></div>
    <div class="rounded-lg border border-gray-700 bg-gray-800 p-3">Profit Factor <b class="ml-1" style="color: {{ $metricColor($pf, 2.5, 0.8) }}">{{ number_format($pf, 2) }}</b></div>
    <div class="rounded-lg border border-gray-700 bg-gray-800 p-3 whitespace-nowrap">Recovery Factor <b class="ml-1" style="color: {{ $metricColor($rf, 3, 0) }}">{{ number_format($rf, 2) }}</b></div>
    <div class="rounded-lg border border-gray-700 bg-gray-800 p-3">Total R <b class="ml-1 text-white">{{ $total * $expectancy }}</b></div>
</div>
<div class="mt-4 flex gap-2">
        <a href="{{ url('calendar/'.$select_journey->id) }}" class="inline-flex items-center rounded-md bg-sky-600 px-3 py-2 text-white hover:bg-sky-500" target="_blank" aria-label="Calendar">
            <span class="fas fa-calendar" />
        </a>
        <a href="{{ url('journey/chart/'.$select_journey->id) }}" class="inline-flex items-center rounded-md bg-amber-600 px-3 py-2 text-white hover:bg-amber-500" target="_blank" aria-label="Performance charts">
            <i class="fas fa-chart-line"></i>
        </a>
        <a href="{{ url('journey/'.$select_journey->id.'/a-plus') }}" class="inline-flex items-center rounded-md bg-emerald-600 px-3 py-2 text-white hover:bg-emerald-500" aria-label="A+ setups" title="A+ setups" target="_blank" rel="noopener">
            <i class="fas fa-star"></i>
        </a>
</div>
<div class="mt-4 space-y-1 text-sm font-semibold text-rose-400">
    <p>*** Execution Performance NOT Trading Performance ***</p>
    <p>*** Drawdown is just an operating expense ***</p>
</div>
