<?php

namespace Tests\Feature\Api;

use App\Models\Garage;
use App\Models\Reservation;
use App\Models\Spot;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SpotTest extends TestCase
{
    use RefreshDatabase;

    public function test_spots_endpoint_returns_only_spots_belonging_to_this_garage(): void
    {
        $garage1 = Garage::factory()->create();

        $garage2 = Garage::factory()->create();

        Spot::factory(4)->create([
            'garage_id' => $garage1->id
        ]);

        $spots = Spot::factory(3)->create([
            'garage_id' => $garage2->id
        ]);

        $this->getJson("api/garages/{$garage2->id}/spots")
            ->assertStatus(200)
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [[
                    "id",
                    "size",
                    "floor",
                    "number"
                ]]
            ])
            ->assertJsonFragment([
                'id' => $spots->random()->id,
            ])->assertJsonFragment([
                'floor' => $spots->random()->floor,
            ])->assertJsonFragment([
                'number' => $spots->random()->number
            ]);
    }

    public function test_it_filters_spots_by_date_availability(): void
    {
        $garage = Garage::factory()->create();

        $spot1 = Spot::factory()->create([
            'garage_id' => $garage->id
        ]);

        $spot2 = Spot::factory()->create([
            'garage_id' => $garage->id
        ]);

        $start = today()->addDay();
        $end = $start->clone()->addHours(31);

        Reservation::factory()->create([
            'spot_id' => $spot2->id,
            'start'   => $start,
            'end'     => $end
        ]);

        $this->getJson("api/garages/{$garage->id}/spots?start={$start->clone()->addMinute()->toISOString()}&end={$end->clone()->subMinute()->toISOString()}")
            ->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonFragment([
                'id' => $spot1->id
            ])
            ->assertJsonMissing([
                'id' => $spot2->id
            ]);
    }

    /** @dataProvider datesProvider */
    public function test_returns_correct_spots_count_based_on_data_provider($reservationStart, $reservationEnd, $start, $end, $expectedCount)
    {
        $garage = Garage::factory()->create();

        Spot::factory()->create([
            'garage_id' => $garage->id
        ]);

        $spot2 = Spot::factory()->create([
            'garage_id' => $garage->id
        ]);

        Reservation::factory()->create([
            'spot_id' => $spot2->id,
            'start'   => $reservationStart,
            'end'     => $reservationEnd
        ]);

        $this->getJson("api/garages/{$garage->id}/spots?start={$start}&end={$end}")
            ->assertStatus(200)
            ->assertJsonCount($expectedCount, 'data');
    }

    public function datesProvider() : array
    {
        $start = today()->addWeek();
        $end = $start->clone()->addHours(31);

        return [
            [
                $start,
                $end,
                $start->clone()->subDays(4)->toISOString(),
                $start->clone()->subDays(3)->toISOString(),
                2
            ],
            [
                $start,
                $end,
                $end->clone()->addDays(4)->toISOString(),
                $end->clone()->addDays(5)->toISOString(),
                2
            ],
            [
                $start,
                $end,
                $start->clone()->subMinute()->toISOString(),
                $end->clone()->subMinute()->toISOString(),
                1
            ],
            [
                $start,
                $end,
                $start->clone()->addMinute()->toISOString(),
                $end->clone()->subMinute()->toISOString(),
                1
            ],
            [
                $start,
                $end,
                $start->clone()->addMinute()->toISOString(),
                $end->clone()->addMinute()->toISOString(),
                1
            ],
            [
                $start,
                $end,
                $start->clone()->subMinute()->toISOString(),
                $end->clone()->addMinute()->toISOString(),
                1
            ]
        ];
    }
}
