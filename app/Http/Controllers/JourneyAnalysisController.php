<?php

namespace App\Http\Controllers;

use App\Models\Journey;
use App\Models\JourneyItem;
use Illuminate\Http\Request;

class JourneyAnalysisController extends Controller
{
    public function index(Request $request)
    {
        // Include soft-deleted journeys so archived backtests remain available here.
        $journeys = Journey::withTrashed()
            ->withCount('items')
            ->orderBy('name')
            ->get();
        $journeyId = (int) $request->query('journey_id', 0);
        $journey = $journeys->firstWhere('id', $journeyId);

        if (!$journey) {
            $journey = $journeys->firstWhere('default', true) ?: $journeys->first();
            $journeyId = $journey ? $journey->id : 0;
        }

        $items = $journeyId
            ? JourneyItem::where('journey_id', $journeyId)->get()
            : collect();

        $sessions = $items->pluck('entry_session')->filter()->unique()->sort()->values();
        $requestedSessions = (array) $request->query('sessions', []);
        // Treat a page load with no selected session values as the initial state.
        // This also keeps every session checked when opening a journey directly.
        $selectedSessions = count($requestedSessions)
            ? array_values(array_intersect($sessions->all(), $requestedSessions))
            : $sessions->all();
        $includeTp1 = $request->has('tp1_present') ? $request->boolean('tp1') : true;
        $includeTp2 = $request->has('tp2_present') ? $request->boolean('tp2') : true;

        $filteredItems = $items->whereIn('entry_session', $selectedSessions)->values();
        $summary = $this->summarize($filteredItems, $includeTp1, $includeTp2);
        $sessionSummaries = $sessions->mapWithKeys(function ($session) use ($items, $selectedSessions, $includeTp1, $includeTp2) {
            $sessionItems = $items->where('entry_session', $session)->values();

            return [$session => [
                'selected' => in_array($session, $selectedSessions, true),
                'summary' => $this->summarize($sessionItems, $includeTp1, $includeTp2),
            ]];
        });

        return view('journey.analysis', compact(
            'journeys', 'journey', 'journeyId', 'sessions', 'selectedSessions',
            'includeTp1', 'includeTp2', 'summary', 'sessionSummaries'
        ));
    }

    private function summarize($items, bool $includeTp1, bool $includeTp2): array
    {
        $resolved = $items->map(function ($item) use ($includeTp1, $includeTp2) {
            $r = 0.0;
            if ($includeTp1 && is_numeric($item->result_r1)) {
                $r += (float) $item->result_r1;
            }
            if ($includeTp2 && is_numeric($item->result_r2)) {
                $r += (float) $item->result_r2;
            }

            return $r;
        });

        $count = $resolved->count();
        $wins = $resolved->filter(fn ($r) => $r > 0)->count();
        $losses = $resolved->filter(fn ($r) => $r < 0)->count();
        $totalR = $resolved->sum();

        return [
            'count' => $count,
            'wins' => $wins,
            'losses' => $losses,
            'win_rate' => $count ? ($wins / $count) * 100 : 0,
            'total_r' => $totalR,
            'average_r' => $count ? $totalR / $count : 0,
        ];
    }
}
