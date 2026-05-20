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
        return view('calendar', compact('journey_id'));
    }

    public function events($journey_id)
    {
        $items = JourneyItem::where('journey_id', $journey_id)->groupBy('date')->get();

        $datas = [];
        foreach ($items as $item) {
            $win = JourneyItem::where('date', $item->date)->where('result_r1', 'WIN')->count();
            $loss = JourneyItem::where('date', $item->date)->where('result_r1', 'LOSS')->count();
            $r = $win - $loss;

            if ($r) {
                $date = Carbon::createFromFormat('d M Y', $item->date)
                    ->format('Y-m-d');
                $datas[] = [
                    'title' => $r.'R',
                    'start' => $date,
                    'classNames' => [
                        $r > 0 ? 'win-trade' : 'lose-trade'
                    ]
                ];
            }
        }

        return response()->json($datas);
    }
}
