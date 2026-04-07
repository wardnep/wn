@php
use App\JourneyItem;
@endphp
@php
    $journey_total = JourneyItem::where('strategy', 'Reversal')->where('journey_id', $select_journey->id)->get();
    $total_order = $journey_total->count();
    $win = $journey_total->where('result', 'WIN')->count();
    $loss = $journey_total->where('result', 'LOSS')->count();
    $tp1 = $journey_total->where('result', 'WIN')->sum('tp1');
    $tp2 = $journey_total->where('result', 'WIN')->sum('tp2');
    $loss_point = $journey_total->where('result', 'LOSS')->sum('tp1');

    $tp12 = $tp1 + $tp2;
    $loss_point2 = $loss_point * 2;

    $winning_streak = 0;
    $losing_streak = 0;
    $win_count = 0;
    $loss_count = 0;
    //
    $prev_date = '';
    $order_date_count = 0;
    foreach ($journey_total as $tmp) {
        if ($tmp->result == 'WIN') {
            $win_count++;
            $loss_count = 0;
        } else if ($tmp->result == 'LOSS') {
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
        if ($prev_date != $tmp->date) {
            $order_date_count++;
        }

        $prev_date = $tmp->date;
    }
@endphp
<h4>Total <b>{{ number_format($total_order) }}</b> Winrate <b>{{ number_format(($win / $total_order) * 100, 2) }}%</b><br />
Win <b>({{ number_format($tp12, 2) }}){{ $win }}</b> Loss <b>({{ number_format($loss_point2, 2) }}){{ $loss }}</b> Point <b>{{ number_format($tp12 - $loss_point2) }}</b><br />
Winning/Losing Streak <b>{{ $winning_streak }}</b>/<b>{{ $losing_streak }}</b><br />
Orders/Day <b>({{ $total_order }}/{{ $order_date_count}}) {{ number_format($total_order / $order_date_count, 2) }}</b><br />
<a href="{{ url('journey/chart/'.$select_journey->id) }}" target="_blank">chart</a>
</h4>
