<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TestDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(SizeSeeder::class);
        $this->call(SpotAttributeSeeder::class);
    }
}
