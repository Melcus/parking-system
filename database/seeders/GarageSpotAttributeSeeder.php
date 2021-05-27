<?php

namespace Database\Seeders;

use App\Models\Garage;
use App\Models\SpotAttribute;
use Illuminate\Database\Seeder;

class GarageSpotAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Garage::get()->each(function (Garage $garage) {
            SpotAttribute::get()->each(function (SpotAttribute $spotAttribute) use ($garage) {
                $garage->spotAttributes()->attach($spotAttribute->id, [
                    'price_per_hour' => rand(20, 99)
                ]);
            });
        });
    }
}
