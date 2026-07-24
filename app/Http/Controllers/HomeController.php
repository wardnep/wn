<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\AccessIp;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $access_ip = new AccessIp();
        $access_ip->ip = $request->header('CF-Connecting-IP') ?? $request->ip();
        $access_ip->save();

        return view('index');
    }
}
