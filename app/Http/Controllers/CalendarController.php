<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Carbon\Carbon;

use App\Models\JourneyItem;

class CalendarController extends Controller
{
    public function index($journey_id)
    {
        $items = JourneyItem::where('journey_id', $journey_id)->groupBy('date')->get();

        $total = 0;
        foreach ($items as $item) {
            $win = JourneyItem::where('date', $item->date)->where('result_r1', 'WIN')->count();
            $loss = JourneyItem::where('date', $item->date)->where('result_r1', 'LOSS')->count();
            $r = ($win * 1.5) - ($loss * 1);

            $total += $r;
        }

        return view('calendar', compact('journey_id', 'total'));
    }

    public function events($journey_id)
    {
        $items = JourneyItem::where('journey_id', $journey_id)->groupBy('date')->get();

        $total = 0;
        $datas = [];
        foreach ($items as $item) {
            $win = JourneyItem::where('date', $item->date)->where('result_r1', 'WIN')->count();
            $loss = JourneyItem::where('date', $item->date)->where('result_r1', 'LOSS')->count();
            $r = ($win * 1.5) - ($loss * 1);

            $total_trade = $win + $loss;

            if ($r) {
                $date = Carbon::createFromFormat('d M Y', $item->date)
                    ->format('Y-m-d');

                if ($r > 1) {
                    $class = 'win-big';
                } elseif ($r > 0) {
                    $class = 'win-trade';
                } elseif ($r < -1) {
                    $class = 'lose-big';
                } else {
                    $class = 'lose-trade';
                }

                $datas[] = [
                    'title' => "($total_trade) {$r}R",
                    'start' => $date,
                    'classNames' => $class
                ];

                $total += $r;
            }
        }

        return response()->json($datas);
    }
}
