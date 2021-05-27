<?php

namespace Database\Factories;

use App\Models\Garage;
use App\Models\Price;
use App\Models\Size;
use Illuminate\Database\Eloquent\Factories\Factory;

class PriceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Price::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'garage_id' => Garage::factory(),
            'size_id'   => Size::inRandomOrder()->first()->id,
            'base'      => rand(100, 5000),
            'rates'     => null
        ];
    }
}
