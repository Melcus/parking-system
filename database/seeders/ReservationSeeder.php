<?php

namespace Database\Seeders;

use App\Models\Reservation;
use App\Models\Spot;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Spot::get()->each(function (Spot $spot) {

            $start = now()->addHours(rand(-15, 15));

            if (rand(0,1)) {
                Reservation::factory()->create([
                    'spot_id' => $spot->id,
                    'start'   => $start,
                    'end'     => $start->clone()->addHours(rand(1, 70)),
                    'paid_at' => $start->clone()->addSeconds(rand(30, 120))
                ]);
            }

            if (rand(0,1)) {
                Reservation::factory()->create([
                    'spot_id' => $spot->id,
                    'start'   => $start_2 = $start->clone()->addHours(rand(71,100)),
                    'end'     => $start_2->clone()->addHours(rand(1, 70)),
                    'paid_at' => $start_2->clone()->addSeconds(rand(30, 120))
                ]);
            }

            if (rand(0,1)) {
                Reservation::factory()->create([
                    'spot_id' => $spot->id,
                    'start'   => $start_3 = $start->clone()->addHours(rand(171,300)),
                    'end'     => $start_3->clone()->addHours(rand(1, 70)),
                    'paid_at' => $start_3->clone()->addSeconds(rand(30, 120))
                ]);
            }
        });
    }
}
