<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Location>
 */
class LocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'longitude' => $this->faker->randomFloat(7, -180, 180),
            'latitude' => $this->faker->randomFloat(7, -90, 90),
            'name' => $this->faker->word,
            'marker_color' => $this->faker->hexColor,
        ];
    }
}
