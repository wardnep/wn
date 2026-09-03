<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;
use Rap2hpoutre\FastExcel\FastExcel;

use App\Models\Journey;
use App\Models\JourneyItem;

class JourneyController extends Controller
{
    public function index(Request $request, $select_journey_id = 0, $edit_journey_item_id = 0, $sort_column = 'id', $sort_direction = 'ASC')
    {
        if (!$select_journey_id) {
            $select_journey = Journey::where('default', true)->first();

            if ($select_journey) {
                $select_journey_id = $select_journey->id;
            } else {
                $select_journey_id = Journey::latest()->first()->id;
            }
        }

        $journeys = Journey::all();

        if ($request->select_journey_id) {
            $select_journey_id = $request->select_journey_id;
        }

        $select_journey = Journey::find($select_journey_id);
        $edit_journey_item = JourneyItem::find($request->edit_journey_item_id);

        $query = JourneyItem::where('journey_id', $select_journey_id)->orderByDesc('id');

        $item_per_page = 50;

        $journey_items = $query->simplePaginate($item_per_page);
        $last_page = ceil($query->count() / $item_per_page);

        $default_date = date2DateThai(Carbon::now()->format('d/m/Y'));
        $default_size = '';
        $total = JourneyItem::count();

        return view('journey.index', compact('journeys', 'select_journey', 'journey_items', 'edit_journey_item', 'default_date', 'default_size', 'sort_column', 'sort_direction', 'exclude_asia', 'exclude_london', 'exclude_london_ny', 'exclude_ny', 'total', 'last_page'));
    }

    public function storeOrUpdate(Request $request)
    {
        $is_create = false;
        $item = JourneyItem::find($request->edit_journey_item_id);
        if (!$item) {
            $is_create = true;
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
        } else if ($is_create) {
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
        } else if ($is_create) {
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
        $item->result_r2 = $request->result_r2 ?: 0;
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
        $journey = Journey::find($journey_id);
        $items = JourneyItem::where('journey_id', $journey_id)->get();

        $win = $items->where('result_r1', 'WIN')->count();
        $loss = $items->where('result_r1', 'LOSS')->count();

        $r = ($win * $journey->rr) - ($loss * 1);

        $win_loss = [];
        $win_rate = [];
        foreach ($items as $item) {
            $win = JourneyItem::where('journey_id', $journey_id)->where('id', '<=', $item->id)->where('result_r1', 'WIN')->count();
            $loss = JourneyItem::where('journey_id', $journey_id)->where('id', '<=', $item->id)->where('result_r1', 'LOSS')->count();

            $win_loss[] = $win - $loss;
            $win_rate[] = ($win / ($win + $loss)) * 100;
        }

        return view('journey.summary.chart', compact('items', 'r', 'win_loss', 'win_rate'));
    }

    public function default($journey_id)
    {
        Journey::query()->update(['default' => false]);

        $journey = Journey::find($journey_id);
        $journey->default = true;
        $journey->save();

        return back();
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
}
