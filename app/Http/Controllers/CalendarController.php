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
        $items = JourneyItem::where('journey_id', $journey_id)
            ->select(
                'date',
                DB::raw('COUNT(*) as orders')
            )
            ->groupBy('date')
            ->get();

        $datas = [];
        foreach ($items as $item) {

            $date = Carbon::createFromFormat('d M Y', $item->date)
                ->format('Y-m-d');

            $datas[] = [
                'title' => 'Meeting Journey '.$journey_id.' ('.$item->orders.')',
                'start' => $date,
            ];
        }

        return view('calendar', compact('journey_id'));
    }

    public function events($journey_id)
    {
        $items = JourneyItem::where('journey_id', $journey_id)
            ->select(
                'date',
                DB::raw('COUNT(*) as orders')
            )
            ->groupBy('date')
            ->get();

        $datas = [];
        foreach ($items as $item) {

            $date = Carbon::createFromFormat('d M Y', $item->date)
                ->format('Y-m-d');

            $datas[] = [
                'title' => 'Meeting Journey '.$journey_id.' ('.$item->orders.')',
                'start' => $date,
            ];
        }

        return response()->json($datas);
    }
}
