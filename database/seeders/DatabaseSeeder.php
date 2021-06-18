<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() : void
    {
        $this->call(SizeSeeder::class);
        $this->call(SpotAttributeSeeder::class);
        $this->call(GarageSeeder::class);
        $this->call(PriceSeeder::class);
        $this->call(GarageSpotAttributeSeeder::class);
        $this->call(SpotSeeder::class);
        $this->call(SpotSpotAttributeSeeder::class);
        $this->call(ReservationSeeder::class);
        $this->call(VehicleSeeder::class);
    }
}
