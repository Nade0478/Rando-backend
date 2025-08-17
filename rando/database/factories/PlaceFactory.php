<?php

namespace Database\Factories;

use App\Models\User;
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
            'name_place' => 'Place ' . fake()->unique()->numberBetween(1, 100),
            'longitude_place' => fake()->longitude(),
            'latitude_place' => fake()->latitude(),
            'description_place' => fake()->paragraph(),
            'image_place' => fake()->imageUrl(640, 480, 'nature'),
            'map_place' => fake()->imageUrl(640, 480, 'maps'),
            'distance_place' => fake()->randomFloat(1, 1, 20),
            'difficulty_place' => fake()->randomElement(['Facile', 'Moyen', 'Difficile']),
            'estimated_time_place' => fake()->time('H:i'),
            'user_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
