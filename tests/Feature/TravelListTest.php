<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Travel;

class TravelListTest extends TestCase
{
    use RefreshDatabase;
    public function test_travel_list_returns_paginated_data_correctly()
    {
        Travel::factory(50)->create(['is_public' => true]);
        $response = $this->get('/api/v1/travels');
        $response->assertStatus(200);
        $response->assertJsonCount(15, 'data');
        $response->assertJsonPath('meta.last_page', 4);
    }
    public function test_travel_list_returns_public_records_only()
    {
        $publicRecord = Travel::factory()->create(['is_public' => true]);
        Travel::factory()->create(['is_public' => false]);

        $response = $this->get('/api/v1/travels');
        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
        $response->assertJsonPath('data.0.name', $publicRecord->name);
    }
}
