<?php

declare(strict_types=1);

namespace Tests\Feature\Api;

use App\Models\Garage;
use App\Models\Reservation;
use App\Models\Spot;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GarageTest extends TestCase
{
    use RefreshDatabase;

    public function test_garages_endpoint(): void
    {
        $garage = Garage::factory()->create();

        Spot::factory(2)->create([
            'garage_id' => $garage->id
        ]);

        $this->getJson('/api/garages')
            ->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonFragment([
                'name'        => $garage->name,
                'zipcode'     => $garage->zipcode,
                'coordinates' => [
                    'lng' => round($garage->lng, 4),
                    'lat' => round($garage->lat, 4)
                ],
                'total_spots' => 2
            ]);
    }

    public function test_garages_endpoint_calculates_free_spots(): void
    {
        $garage = Garage::factory()->create();

        $start = Carbon::parse("01/06/2021");
        $end = Carbon::parse("03/06/2021");

        $this->travelTo($start->clone()->addMinute());

        $spot = Spot::factory()->create([
            'garage_id' => $garage->id
        ]);

        Reservation::factory()->create([
            'start'   => $start,
            'end'     => $end,
            'spot_id' => $spot->id
        ]);

        Spot::factory()->create([
            'garage_id' => $garage->id,
        ]);

        $this->getJson('/api/garages')
            ->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonFragment([
                'total_spots' => 2,
                'free_spots'  => 1
            ]);

        $this->travelTo(Carbon::parse("09/06/2021"));

        $this->getJson('/api/garages')
            ->assertJsonFragment([
                'total_spots' => 2,
                'free_spots'  => 2
            ]);
    }

}
