<?php

namespace Tests\Unit\Models;

use App\Models\Garage;
use App\Models\Price;
use App\Models\Size;
use App\Models\Spot;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class PriceTest extends TestCase
{
    use DatabaseMigrations;

    public function test_price_test()
    {
        $garage = Garage::factory()->create();

        $price = Price::factory()->create([
            'garage_id' => $garage->id
        ]);


        dd($garage->prices->toArray());

        $spot = Spot::factory()->create([
            'garage_id' => $garage->id,
        ]);

        dd($garage->spots()->first()->garage);

    }
}
