<?php

namespace Tests\Feature;

use App\Models\Journey;
use App\Models\JourneyItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class JourneyTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_open_journey_log()
    {
        $this->actingAs(User::factory()->create());
        $journey = $this->createJourney();

        $response = $this->get('/journey/'.$journey->id);

        $response->assertOk();
        $response->assertViewIs('journey.index');
    }

    public function test_authenticated_user_can_add_a_trade_to_journey()
    {
        $this->actingAs(User::factory()->create());
        $journey = $this->createJourney();

        $response = $this->post('/journey', $this->tradeData($journey));

        $response->assertRedirect('/journey?select_journey_id='.$journey->id.'&page=1');
        $this->assertDatabaseHas('journey_items', [
            'journey_id' => $journey->id,
            'date' => '09 Nov 2026',
            'position' => 'BUY',
            'result_r1' => 'WIN',
            'grade' => 'A',
            'note' => 'Setup matched plan',
        ]);
    }

    public function test_authenticated_user_can_update_a_trade()
    {
        $this->actingAs(User::factory()->create());
        $journey = $this->createJourney();
        $item = $this->createTradeItem($journey);

        $data = $this->tradeData($journey);
        $data['edit_journey_item_id'] = $item->id;
        $data['position'] = 'SELL';
        $data['result_r1'] = 'LOSS';
        $data['grade'] = 'B';

        $response = $this->post('/journey', $data);

        $response->assertRedirect('/journey?select_journey_id='.$journey->id.'&page=1');
        $this->assertDatabaseHas('journey_items', [
            'id' => $item->id,
            'position' => 'SELL',
            'result_r1' => 'LOSS',
            'grade' => 'B',
        ]);
    }

    public function test_authenticated_user_can_delete_a_trade()
    {
        $this->actingAs(User::factory()->create());
        Storage::fake('r2');
        $journey = $this->createJourney();
        $item = $this->createTradeItem($journey);

        $response = $this->get('/journey/delete/'.$journey->id.'/'.$item->id);

        $response->assertRedirect('/journey/'.$journey->id);
        $this->assertSoftDeleted('journey_items', ['id' => $item->id]);
    }

    private function createJourney(): Journey
    {
        $journey = new Journey();
        $journey->name = 'Test journey';
        $journey->note = '';
        $journey->rr = '2';
        $journey->default = true;
        $journey->save();

        return $journey;
    }

    private function createTradeItem(Journey $journey): JourneyItem
    {
        $item = new JourneyItem();
        foreach ($this->tradeData($journey) as $attribute => $value) {
            if ($attribute === 'select_journey_id') {
                $item->journey_id = $value;
            } elseif (!in_array($attribute, ['edit_journey_item_id', 'page'], true)) {
                $item->{$attribute} = $value;
            }
        }
        $item->save();

        return $item;
    }

    private function tradeData(Journey $journey): array
    {
        return [
            'select_journey_id' => $journey->id,
            'edit_journey_item_id' => 0,
            'page' => 1,
            'date' => '09 Nov 2026',
            'entry_session' => 'London',
            'exit_session' => 'NY',
            'position' => 'BUY',
            'result' => 'WIN',
            'size' => '1',
            'tp1' => '2',
            'tp2' => '0',
            'result_r1' => 'WIN',
            'result_r2' => '0',
            'grade' => 'A',
            'image' => 'https://example.test/chart.png',
            'image2' => '',
            'strategy' => 'breakout',
            'note' => 'Setup matched plan',
        ];
    }
}
