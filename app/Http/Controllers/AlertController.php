<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\PriceLevel;
use App\Models\TimeAlert;

class AlertController extends Controller
{
    public function index($edit_id = 0)
    {
        $price_levels = PriceLevel::all()->sortByDesc('price', SORT_NUMERIC);
        $price_levels->count();

        $edit_price_level = null;
        if ($edit_id) {
            $edit_price_level = PriceLevel::find($edit_id);
        }

        $time_alerts = TimeAlert::orderBy('alert_time')->get();
        return view('alert.index', compact('price_levels', 'edit_price_level', 'time_alerts'));
    }

    public function storeTimeAlert(Request $request)
    {
        $data = $request->validate([
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i'],
            'time_message' => ['nullable', 'string', 'max:255'],
        ]);

        if ($data['end_time'] <= $data['start_time']) {
            return redirect()->back()->withInput()->withErrors([
                'end_time' => 'เวลาสิ้นสุดต้องอยู่หลังเวลาเริ่มต้นในวันเดียวกัน',
            ]);
        }

        TimeAlert::create([
            'alert_time' => $data['start_time'],
            'end_time' => $data['end_time'],
            'message' => $data['time_message'] ?? '',
            'active' => true,
        ]);

        return redirect('alert');
    }

    public function deleteTimeAlert($alert_id)
    {
        TimeAlert::destroy($alert_id);
        return redirect()->back();
    }

    public function storeOrUpdate(Request $request)
    {
        $data = $request->validate([
            'price' => ['required', 'numeric'],
            'time_frame' => ['required', 'in:15m,1h,4h,D'],
            'price_message' => ['nullable', 'string'],
        ]);

        $price_level = new PriceLevel();
        if ($request->input('id')) {
            $price_level = PriceLevel::find($request->input('id'));
            $price_level->active = $request->input('active') == '1' ? true : false;
        } else {
            $price_level->active = true;
        }

        $price_level->time_frame = $data['time_frame'];
        $price_level->price = $data['price'];
        $price_level->message = $data['price_message'] ?? '';
        $price_level->save();

        return redirect('alert');
    }

    public function delete($alert_id)
    {
        $price_level = PriceLevel::find($alert_id);
        if ($price_level) {
            $price_level->delete();
        }

        return redirect()->back();
    }
}
