<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

use DB;

class QuantController extends Controller
{
    public function index(Request $request)
    {
        $response = Http::get('http://34.158.61.206:5000/status');
        $data = $response->json();

        return view('quant.index', compact('data'));
    }

    public function logs(Request $request)
    {
        $response = Http::get('http://34.158.61.206:5000/status');
        $data = $response->json();

        $logs = DB::connection('sqlite2')->select('select * from logs order by id desc', []);

        return view('quant.log', compact('data', 'logs'));
    }
}
