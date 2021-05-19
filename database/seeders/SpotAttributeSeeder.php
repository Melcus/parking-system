<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpotAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('spot_attributes')->insert([
            ['name' => 'electric'],
            ['name' => 'for_women'],
            ['name' => 'with_kids'],
            ['name' => 'handicapped']
        ]);
    }
}
