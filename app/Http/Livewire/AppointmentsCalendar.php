<?php

namespace App\Http\Livewire;

use Asantibanez\LivewireCalendar\LivewireCalendar;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class AppointmentsCalendar extends LivewireCalendar
{
    public function events() : Collection
    {
        return collect([
            [
                'id' => 1,
                'title' => 'Breakfast',
                'description' => 'Pancakes! 🥞',
                'date' => Carbon::today(),
            ],
            [
                'id' => 2,
                'title' => 'Meeting with Pamela',
                'description' => 'Work stuff',
                'date' => Carbon::tomorrow(),
            ],
        ]);
    }
}
