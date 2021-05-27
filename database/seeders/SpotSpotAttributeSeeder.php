<?php

namespace Database\Seeders;

use App\Models\Spot;
use App\Models\SpotAttribute;
use Illuminate\Database\Seeder;

class SpotSpotAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Spot::get()->each(function (Spot $spot) {
            $spot->spotAttributes()->attach(SpotAttribute::inRandomOrder()->take(rand(0, 3))->pluck('id'));
        });
    }
}
