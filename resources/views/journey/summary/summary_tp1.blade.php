@php
    use App\JourneyItem;

    $query = JourneyItem::where('journey_id', 9);
    if ($exclude_asia == 'Y') {
        $query->where('session', '<>', 'Asia');
    }
    if ($exclude_london == 'Y') {
        $query->where('session', '<>', 'London');
    }
    if ($exclude_london_ny == 'Y') {
        $query->where('session', '<>', 'London + NY');
    }
    if ($exclude_ny == 'Y') {
        $query->where('session', '<>', 'NY');
    }
    $items = $query->get();

    $total = $items->count();
    $win = $items->where('result', 'WIN')->count();
    $loss = $items->where('result', 'LOSS')->count();
    $win_point = $items->where('result', 'WIN')->sum('tp1');
    $loss_point = $items->where('result', 'LOSS')->sum('tp1') * 2;

    $win_rate = $total ? number_format(($win / $total) * 100, 2) : 0;
    $loss_rate = $total ? number_format(100 - $win_rate, ) : 0;

    $winning_streak = 0;
    $losing_streak = 0;
    $win_count = 0;
    $loss_count = 0;

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
            $equity += $item->result_r1;

            if ($equity > $peak) {
                $peak = $equity;
            }

            $dd = $peak - $equity;
            if ($dd > $maxDD) {
                $maxDD = $dd;
            }
        }

        return number_format($maxDD, 2);
    }

    function expectancy($items)
    {
        $total = $items->count();
        if (!$total) return 0;

        $sum = $items->sum('result_r1');

        return number_format($sum / $total, 2);
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

    $gross_profit = $items->where('result_r1', '>', 0)->sum('result_r1');
    $gross_loss = abs($items->where('result_r1', '<', 0)->sum('result_r1'));
    $pf = $gross_loss ? number_format($gross_profit / $gross_loss, 2) : 0;

    $net_profit = $items->sum('result_r1');
    $rf = (int) $all_dd ? number_format($net_profit / $all_dd, 2) : 0;

    $start_date = $items->first() ? date2MySqlDate2($items->first()->date) : '';
    $last_date = $items->first() ? date2MySqlDate2($items->sortByDesc('id')->first()->date) : '';
    $start = Carbon::parse($start_date);
    $end = Carbon::parse($last_date);
    $weekdays = $start->diffInWeekdays($end);
    $obd = $weekdays ? number_format($total / $weekdays, 2) : 0;
@endphp
@extends('_layouts.journey')

@section('title')
    Trading Journey
@endsection

@section('content')
<section class="content">
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <h4>TP1</h4>
                </div>
                <div class="col-md-3">
                    Total <b>{{ $total }}</b><br />
                    Win <b>{{ $win }}</b> Loss <b>{{ $loss }}</b><br />
                    Win Rate <b>{{ $win_rate }}%</b><br />
                    Winning/Losing Streak <b>{{ $winning_streak }}</b>/<b>{{ $losing_streak }}</b><br />
                    Orders/Day <b>{{ $obd }}</b>
                </div>
                <div class="col-md-3">
                    Expectancy <b>{{ $all_exp }}</b><br />
                    Asia <b>{{ $asia_exp }}</b><br />
                    London <b>{{ $london_exp }}</b><br />
                    London + NY <b>{{ $london_ny_exp }}</b><br />
                    NY <b>{{ $ny_exp }}</b>
                </div>
                <div class="col-md-3">
                    Max DD <b>{{ $all_dd }}R</b><br />
                    Asia <b>{{ $asia_dd }}R</b><br />
                    London <b>{{ $london_dd }}R</b><br />
                    London + NY <b>{{ $london_ny_dd }}R</b><br />
                    NY <b>{{ $ny_dd }}R</b>
                </div>
                <div class="col-md-3">
                    Profit Factor <b>{{ $pf }}</b><br />
                    Recovery Factor <b>{{ $rf }}</b><br />
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
