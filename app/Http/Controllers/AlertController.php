<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\PriceLevel;

class AlertController extends Controller
{
    public function index($edit_id = 0)
    {
        $price_levels = PriceLevel::all();
        $price_levels->count();

        $edit_price_level = null;
        if ($edit_id) {
            $edit_price_level = PriceLevel::find($edit_id);
        }

        return view('alert.index', compact('price_levels', 'edit_price_level'));
    }

    public function storeOrUpdate(Request $request)
    {
        $price_level = new PriceLevel();
        if ($request->input('id')) {
            $price_level = PriceLevel::find($request->input('id'));
            $price_level->active = $request->input('active') == '1' ? true : false;
        } else {
            $price_level->active = true;
        }

        $price_level->price = $request->input('price');
        $price_level->message = $request->input('message');
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
