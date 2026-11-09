<?php

namespace Tests\Browser;

use App\Models\Journey;
use App\Models\JourneyItem;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class JourneyFormTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_user_can_enter_a_trade_in_the_journey_form_and_save_it()
    {
        $user = User::factory()->create();

        $journey = new Journey();
        $journey->name = 'Browser test journey';
        $journey->note = '';
        $journey->rr = '2';
        $journey->default = true;
        $journey->save();

        $this->browse(function (Browser $browser) use ($user, $journey) {
            $browser->loginAs($user)
                ->visit('/journey/'.$journey->id)
                ->storeSource('journey-form-page')
                ->assertPathIs('/journey/'.$journey->id)
                ->assertPresent('input[name="date"]')
                ->type('input[name="date"]', '09 Nov 2026')
                ->select('position', 'SELL')
                ->select('result_r1', 'WIN')
                ->type('input[name="grade"]', 'A')
                ->type('input[name="image"]', 'https://example.test/trade-chart.png')
                ->type('textarea[name="note"][rows="3"]', 'Submitted from the browser UI')
                ->click('button[type="submit"]')
                ->assertPathIs('/journey');
        });

        $this->assertDatabaseHas('journey_items', [
            'journey_id' => $journey->id,
            'date' => '09 Nov 2026',
            'position' => 'SELL',
            'result_r1' => 'WIN',
            'grade' => 'A',
            'image' => 'https://example.test/trade-chart.png',
            'note' => 'Submitted from the browser UI',
        ]);
    }
}
