<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class IpWhoisService
{
    public function lookup(string $ip): ?array
    {
        // ข้าม private/local IP
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
            return null;
        }

        try {
            $response = Http::timeout(5)->get("http://ip-api.com/json/{$ip}", [
                'fields' => 'status,message,country,city,isp,org,as,query',
            ]);

            if (!$response->successful()) {
                Log::warning("Whois lookup HTTP error for {$ip}: " . $response->status());
                return null;
            }

            $data = $response->json();

            if (($data['status'] ?? null) !== 'success') {
                Log::warning("Whois lookup failed for {$ip}: " . ($data['message'] ?? 'unknown'));
                return null;
            }

            return $data;
        } catch (\Exception $e) {
            Log::error("Whois lookup exception for {$ip}: " . $e->getMessage());
            return null;
        }
    }
}
