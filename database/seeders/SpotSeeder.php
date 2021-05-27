<?php

namespace Database\Seeders;

use App\Models\Garage;
use App\Models\Spot;
use Illuminate\Database\Seeder;

class SpotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Garage::get()->each(function (Garage $garage) {
            Spot::factory()->count(rand(10, 30))->create([
                'garage_id' => $garage->id
            ]);
        });
    }
}
