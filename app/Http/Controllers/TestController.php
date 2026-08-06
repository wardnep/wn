<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\IpWhoisService;

use App\Models\AccessIp;
use App\Models\JourneyItem;

class TestController extends Controller
{
    public function index(IpWhoisService $whois)
    {
        dd(AccessIp::whereIsNull('isp')->get());

        foreach (AccessIp::where('isp', '=', '')->get() as $access_ip) {
            $result = $whois->lookup($access_ip->ip);

            // dd($result);

            if (!$result) {
                // dd($response->status());
            } else {
                $access_ip->isp = $result['isp'];
                $access_ip->org = $result['org'];
                $access_ip->country = $result['country'];
                $access_ip->city = $result['city'];
                $access_ip->whois_raw = json_encode($result);
                $access_ip->save();
            }
        }

        dd('Done');
    }
}
