<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\PriceLevel;
use App\Models\TimeAlertSetting;

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

        $time_alert_enabled = TimeAlertSetting::firstOrCreate(['id' => 1], ['enabled' => false])->enabled;
        return view('alert.index', compact('price_levels', 'edit_price_level', 'time_alert_enabled'));
    }

    public function toggleTimeAlert(Request $request)
    {
        $data = $request->validate(['enabled' => ['required', 'boolean']]);
        $setting = TimeAlertSetting::firstOrCreate(['id' => 1], ['enabled' => false]);
        $setting->enabled = $data['enabled'];
        $setting->save();

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
