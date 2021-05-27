<?php

namespace Database\Seeders;

use App\Models\Size;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::get()->each(function (User $user) {
            Vehicle::factory()->create([
                'user_id' => $user->id,
                'size_id' => Size::inRandomOrder()->first()->id
            ]);
        });
    }
}
