<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PositionSizingController extends Controller
{
    public function index()
    {
        return view('position_sizing.index');
    }
}
