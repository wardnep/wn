<?php

namespace App\Http\Controllers\Journey;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;
use Rap2hpoutre\FastExcel\FastExcel;

use App\Models\Journey;
use App\Models\JourneyItem;

class HomeController extends Controller
{
    public function index(Request $request, $select_journey_id = 12, $edit_journey_item_id = 0, $sort_column = 'id', $sort_direction = 'ASC')
    {
        $exclude_asia = 'Y';
        $exclude_london = 'Y';
        $exclude_london_ny = $request->exclude_london_ny ?: 'N';
        $exclude_ny = 'Y';

        $journeys = Journey::all();

        if ($request->select_journey_id) {
            $select_journey_id = $request->select_journey_id;
        }

        $select_journey = Journey::find($select_journey_id);
        $edit_journey_item = JourneyItem::find($request->edit_journey_item_id);

        $query = JourneyItem::where('journey_id', $select_journey_id);
        // $query->where('entry_session', '<>', 'London');

        $journey_items = $query->paginate(20);

        if ($select_journey->items() && $select_journey->items()->latest()->first()) {
            $default_date = $select_journey->items()->latest()->first()->date;
            $default_size = $select_journey->items()->latest()->first()->size;
        } else {
            $default_date = date2DateThai(Carbon::now()->format('d/m/Y'));
            $default_size = '';
        }

        return view('journey.index', compact('journeys', 'select_journey', 'journey_items', 'edit_journey_item', 'default_date', 'default_size', 'sort_column', 'sort_direction', 'exclude_asia', 'exclude_london', 'exclude_london_ny', 'exclude_ny'));
    }

    public function storeOrUpdate(Request $request)
    {
        $item = JourneyItem::find($request->edit_journey_item_id);
        if (!$item) {
            $item = new JourneyItem;
        }

        if ($request->image) {
            if ($item->image) {
                Storage::disk('r2')->delete($item->image);
            }

            $filename = uniqid().'.'.$request->image->guessExtension();
            $image_path = Storage::disk('r2')->putFileAs(
                '/',
                $request->image,
                $filename,
                'public'
            );

            $item->image = $image_path;
        } else {
            $item->image = '';
        }

        if ($request->image2) {
            if ($item->image2) {
                Storage::disk('r2')->delete($item->image2);
            }

            $filename = uniqid().'.'.$request->image2->guessExtension();
            $image2_path = Storage::disk('r2')->putFileAs(
                '/',
                $request->image2,
                $filename,
                'public'
            );

            $item->image2 = $image2_path;
        } else {
            $item->image2 = '';
        }

        $item->journey_id = $request->select_journey_id;
        $item->date = $request->date ?: '';
        $item->entry_session = $request->entry_session ?: '';
        $item->exit_session = $request->exit_session ?: '';
        $item->position = $request->position ?: '';
        $item->result = $request->result ?: '';
        $item->size = $request->size ?: 0;
        $item->tp1 = $request->tp1 ?: 0;
        $item->tp2 = $request->tp2 ?: 0;
        $item->result_r1 = $request->result_r1 ?: 0;
        $item->result_r2 = '';
        $item->grade = $request->grade ?: '';
        $item->strategy = $request->strategy ?: '';
        $item->note = $request->note ?: '';
        $item->save();

        return redirect("journey?select_journey_id=$request->select_journey_id&page=$request->page");
    }

    public function delete($select_journey_id, $edit_journey_item_id)
    {
        $item = JourneyItem::find($edit_journey_item_id);
        Storage::disk('r2')->delete($item->image);
        $item->delete();

        return redirect("journey/$select_journey_id");
    }

    public function note(Request $request)
    {
        $journey = Journey::find($request->journey_id);
        $journey->note = $request->note;
        $journey->save();

        return back();
    }

    public function chart($journey_id)
    {
        return view('journey.summary.chart', compact('journey_id'));
    }

    // public function chart1()
    // {
    //     $items = JourneyChartData1::get();

    //     return view('journey.summary.chart1', compact('items'));
    // }

    public function chart2($journey_id)
    {
        $items = JourneyItem::where('journey_id', $journey_id)->get();

        // $items = JourneyItem::where('journey_id', 3)
        //     ->orWhere('journey_id', 4)->get();

        return view('journey.summary.chart2', compact('items'));
    }

    public function chart3($journey_id, $exclude_asia = 'N')
    {
        $months = ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];

        $data = [];
        foreach ($months as $month) {
            if ($exclude_asia == 'N') {
                $items = JourneyItem::where('journey_id', $journey_id)
                    ->where('date', 'LIKE', "%$month%")->get();
            } else {
                $items = JourneyItem::where('journey_id', $journey_id)
                    ->where('session', '<>', 'Asia')
                    ->where('date', 'LIKE', "%$month%")->get();
            }


            $profit = 0;
            $loss = 0;
            foreach ($items as $item) {
                if ($item->result == 'WIN') {
                    $profit += $item->tp1 + $item->tp2;
                }

                if ($item->result == "LOSS") {
                    $loss += $item->tp1 * 2;
                }
            }

            $datas[] = [$month, $profit, $loss];
        }

        return view('journey.summary.chart3', compact('datas'));
    }

    public function chart4($journey_id)
    {
        $datas = [];
        $prev_date = "";
        $order_date_count = 0;
        foreach (JourneyItem::where('journey_id', $journey_id)->distinct('date')->pluck('date') as $date) {
            $order_count = JourneyItem::where('date', $date)->count();

            $datas[] = [
                $date,
                $order_count
            ];
        }

        return view('journey.summary.chart4', compact('datas'));
    }

    public function chart5($journey_id)
    {
        $query = JourneyItem::where('journey_id', $journey_id);
        $query->where('entry_session', '<>', 'London');
        $items = $query->get();

        return view('journey.summary.chart5', compact('items'));
    }

    public function download($journey_id)
    {
        $query = JourneyItem::where('journey_id', $journey_id);
        // $query->where('exit_session', 'Asia');

        $items = $query->get();
        $data = [];
        $count = 0;
        foreach ($items as $item) {
            $data[] = [
                'no' => ++$count,
                'date' => $item->date,
                'entry_session' => $item->entry_session,
                'exit_session' => $item->exit_session,
                'result' => $item->result,
                'sl' => $item->result == 'LOSS' ? $item->tp1 : '',
                'tp1' => $item->result == 'WIN' ? $item->tp1 : '',
                'r' => number_format($item->result_r1, 2),
                'setup' => $item->strategy
            ];
        }

        $start_date = $items->first() ? date2MySqlDate2($items->first()->date) : '';
        $last_date = $items->first() ? date2MySqlDate2($items->sortByDesc('id')->first()->date) : '';
        $start = Carbon::parse($start_date);
        $end = Carbon::parse($last_date);

        $part = "storage/reports/".$start->format('d-M-y')."_".$end->format('d-M-y').".xlsx";
        (new FastExcel($data))->export($part);
        return response()->download($part);
    }

    public function image($journey_id, $journey_item_id) {
        $item = JourneyItem::find($journey_item_id);
        $prev_item = JourneyItem::where('journey_id', $journey_id)->where('id', '<', $journey_item_id)->first();
        $next_item = JourneyItem::where('journey_id', $journey_id)->where('id', '>', $journey_item_id)->first();

        $total = JourneyItem::where('journey_id', $journey_id)->count();
        $ids = JourneyItem::where('journey_id', $journey_id)->pluck('id')->toArray();
        $no = array_search($item->id, $ids) + 1;

        return view('journey.image', compact('item', 'prev_item', 'next_item', 'no', 'total'));
    }

    public function summary_tp(Request $request)
    {
        $exclude_asia = $request->exclude_asia ?: 'Y';
        $exclude_london = $request->exclude_london ?: 'N';
        $exclude_london_ny = $request->exclude_london_ny ?: 'N';
        $exclude_ny = $request->exclude_ny ?: 'N';

        return view('journey.summary.summary_tp', compact('exclude_asia', 'exclude_london', 'exclude_london_ny', 'exclude_ny'));
    }

    public function summary_tp1($exclude_asia, $exclude_london, $exclude_london_ny, $exclude_ny)
    {
        return view('journey.summary.summary_tp1', compact('exclude_asia', 'exclude_london', 'exclude_london_ny', 'exclude_ny'));
    }

    public function summary_tp2($exclude_asia, $exclude_london, $exclude_london_ny, $exclude_ny)
    {
        return view('journey.summary.summary_tp2', compact('exclude_asia', 'exclude_london', 'exclude_london_ny', 'exclude_ny'));
    }
}
