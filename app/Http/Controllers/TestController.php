<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\JourneyItem;

class TestController extends Controller
{
    public function index()
    {
        $items = JourneyItem::where('journdy_id', 14)->get();
        foreach ($items as $item) {
            $item->date = str_replace($item->date, '1481', 2024);
            $item->save();
        }

        dd('Done');
    }
}
