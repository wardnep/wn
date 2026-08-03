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
        foreach (AccessIp::all() as $access_ip) {
            $result = $whois->lookup($access_ip->ip);

            dd($result);

            if (!$response->successful()) {
                dd($response->status());
            } else {
                $data = $response->json();

                $access_ip->isp = $data['isp'];
                $access_ip->org = $data['org'];
                $access_ip->country = $data['country'];
                $access_ip->city = $data['city'];
                $access_ip->whois_raw = json_encode($data);
                $access_ip->save();
            }
        }

        dd('Done');
    }
}
