<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\JourneyItem;

class TestController extends Controller
{
    public function index()
    {
        foreach (JourneyItem::all() as $item) {
            if (str_contains($item->date, 'มกราคม')) {
                $item->date = str_replace('มกราคม', 'Jan', $item->date);
            } else if (str_contains($item->date, 'กุมภาพันธ์')) {
                $item->date = str_replace('กุมภาพันธ์', 'Feb', $item->date);
            } else if (str_contains($item->date, 'มีนาคม')) {
                $item->date = str_replace('มีนาคม', 'Mar', $item->date);
            } else if (str_contains($item->date, 'เมษายน')) {
                $item->date = str_replace('เมษายน', 'Apr', $item->date);
            } else if (str_contains($item->date, 'พฤษภาคม')) {
                $item->date = str_replace('พฤษภาคม', 'May', $item->date);
            } else if (str_contains($item->date, 'มิถุนายน')) {
                $item->date = str_replace('มิถุนายน', 'Jun', $item->date);
            } else if (str_contains($item->date, 'กรกฎาคม')) {
                $item->date = str_replace('กรกฎาคม', 'Jul', $item->date);
            } else if (str_contains($item->date, 'สิงหาคม')) {
                $item->date = str_replace('สิงหาคม', 'Aug', $item->date);
            } else if (str_contains($item->date, 'กันยายน')) {
                $item->date = str_replace('กันยายน', 'Sep', $item->date);
            } else if (str_contains($item->date, 'ตุลาคม')) {
                $item->date = str_replace('ตุลาคม', 'Oct', $item->date);
            } else if (str_contains($item->date, 'พฤศจิกายน')) {
                $item->date = str_replace('พฤศจิกายน', 'Nov', $item->date);
            } else if (str_contains($item->date, 'ธันวาคม')) {
                $item->date = str_replace('ธันวาคม', 'Dec', $item->date);
            }

            $dates = explode(' ', $item->date);
            $byear = $dates[2];
            $cyear = $byear -543;

            $item->date = str_replace($byear, $cyear, $item->date);
            $item->save();
        }

        dd('Done');
    }
}
