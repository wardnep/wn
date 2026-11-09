<?php

namespace Tests\Feature;

use App\Services\IpWhoisService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_position_sizing_is_available_without_authentication()
    {
        $this->mock(IpWhoisService::class, function ($mock) {
            $mock->shouldReceive('lookup')->once()->andReturn(null);
        });

        $response = $this->get('/position_sizing');

        $response->assertOk();
        $response->assertViewIs('position_sizing.index');
        $this->assertDatabaseHas('access_ips', [
            'ip' => '127.0.0.1',
            'page' => 'position_sizing',
        ]);
    }

    public function test_trade_journal_requires_authentication()
    {
        $response = $this->get('/journey');

        $response->assertRedirect('/login');
    }
}
