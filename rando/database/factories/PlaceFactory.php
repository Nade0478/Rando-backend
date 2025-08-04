<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Place>
 */
class PlaceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name_place' => $this->faker->words(3, true),
            'description_place' => $this->faker->text(300),
            'latitude_place' => $this->faker->latitude(),
            'longitude_place' => $this->faker->longitude(),
            'image_place' => $this->faker->imageUrl(640, 480, 'nature', true),
            'map_place' => $this->faker->imageUrl(640, 480, 'maps', true),
            'distance_place' => $this->faker->randomFloat(1, 1, 25),
            'difficulty_place' => $this->faker->randomElement(['Facile', 'Moyen', 'Difficile']),
            'estimated_time_place' => Carbon::createFromFormat('H:i:s', $this->faker->time())->format('H:i'),
        ];
    }
}
