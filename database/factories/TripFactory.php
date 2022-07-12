<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Car;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Trip>
 */
class TripFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'date' => $this->faker->iso8601(),
            'miles' => $this->faker->randomFloat(1, 10, 1000),
            'total' => 0,
            'car_id' => Car::factory(),
        ];
    }
}
