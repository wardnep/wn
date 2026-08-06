<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Carbon\Carbon;

use App\Models\JourneyItem;

class CalendarController extends Controller
{
    public function index($journey_id, $rr = 1.5)
    {
        $items = JourneyItem::where('journey_id', $journey_id)->groupBy('date')->get();

        // dd($items);

        $total = 0;
        foreach ($items as $item) {
            $win = JourneyItem::where('journey_id', $journey_id)->where('date', $item->date)->where('result_r1', 'WIN')->count();
            $loss = JourneyItem::where('journey_id', $journey_id)->where('date', $item->date)->where('result_r1', 'LOSS')->count();
            $r = ($win * $rr) - ($loss * 1);

            $total += $r;
        }

        return view('calendar', compact('journey_id', 'total', 'rr'));
    }

    public function monthSummary($journey_id, Request $request, $rr = 1.5)
    {
        $start = $request->get('start'); // Y-m-d
        $end = $request->get('end');

        // แปลงกลับเป็น format ที่ใช้ใน DB (d M Y)
        $items = JourneyItem::where('journey_id', $journey_id)
            ->groupBy('date')
            ->get();

        $total = 0;
        foreach ($items as $item) {
            $date = Carbon::createFromFormat('d M Y', $item->date)->format('Y-m-d');

            if ($date >= $start && $date < $end) {
                $win  = JourneyItem::where('journey_id', $journey_id)->where('date', $item->date)->where('result_r1', 'WIN')->count();
                $loss = JourneyItem::where('journey_id', $journey_id)->where('date', $item->date)->where('result_r1', 'LOSS')->count();
                $total += ($win * $rr) - ($loss * 1);
            }
        }

        return response()->json(['total' => $total]);
    }

    public function events($journey_id, $rr = 1.5)
    {
        $items = JourneyItem::where('journey_id', $journey_id)->groupBy('date')->get();

        // dd($items);

        $total = 0;
        $datas = [];
        foreach ($items as $item) {
            $win = JourneyItem::where('journey_id', $journey_id)->where('date', $item->date)->where('result_r1', 'WIN')->count();
            $loss = JourneyItem::where('journey_id', $journey_id)->where('date', $item->date)->where('result_r1', 'LOSS')->count();
            $r = ($win * $rr) - ($loss * 1);

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
                    'title' => "{$r}R ($total_trade)",
                    'start' => $date,
                    'classNames' => $class
                ];

                $total += $r;
            }
        }

        return response()->json($datas);
    }
}
