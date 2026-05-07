<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index()
    {
        return view('calendar');
    }

    public function events()
    {
        return response()->json([
            [
                'title' => 'Meeting',
                'start' => '2026-05-10',
            ],
            [
                'title' => 'Holiday',
                'start' => '2026-05-15',
                'end' => '2026-05-17',
            ]
        ]);
    }
}
