<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\IpWhoisService;

use App\Models\AccessIp;

class HomeController extends Controller
{
    public function index(Request $request, IpWhoisService $whois)
    {


        $access_ip = new AccessIp();
        $access_ip->ip = $request->header('CF-Connecting-IP') ?? $request->ip();

        $result = $whois->lookup($access_ip->ip);
        if ($result) {
            $access_ip->isp = $result['isp'];
            $access_ip->org = $result['org'];
            $access_ip->country = $result['country'];
            $access_ip->city = $result['city'];
            $access_ip->whois_raw = json_encode($result);
        }

        $access_ip->save();

        return view('index');
    }
}
