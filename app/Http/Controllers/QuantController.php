<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuantController extends Controller
{
    public function index(Request $request)
    {
        return view('quant.index');
    }
}
