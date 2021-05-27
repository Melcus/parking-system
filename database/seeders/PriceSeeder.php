<?php

namespace Database\Seeders;

use App\Models\Garage;
use App\Models\Price;
use App\Models\Size;
use Illuminate\Database\Seeder;

class PriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Garage::get()->each(function (Garage $garage) {
            Price::factory()->create([
                'garage_id' => $garage->id,
                'size_id'   => 1,
                'base'      => 500
            ]);

            Price::factory()->create([
                'garage_id' => $garage->id,
                'size_id'   => 2,
                'base'      => 600,
                'rates'     => [
                    ['amount' => 2000, 'hours' => implode('-', [$start = rand(0,22), rand($start, 23) ]), 'days' => array_unique(range(1,rand(1,7)))]
                ]
            ]);

            Price::factory()->create([
                'garage_id' => $garage->id,
                'size_id'   => 3,
                'base'      => 700
            ]);
        });
    }
}
