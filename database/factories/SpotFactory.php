<?php

namespace Database\Factories;

use App\Models\Garage;
use App\Models\Size;
use App\Models\Spot;
use Illuminate\Database\Eloquent\Factories\Factory;

class SpotFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Spot::class;

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
            'floor'     => rand(-15, 15),
            'number'    => rand(1, 150),
        ];
    }
}
