<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\At_Favorite>
 */
class At_FavoriteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 10),
            'place_id' => $this->faker->numberBetween(1, 50),
            'is_favorite' => $this->faker->boolean(80), // 80% de chances que ce soit un favori
            'rating' => $this->faker->optional()->numberBetween(1, 5), // note entre 1 et 5
            'comment' => $this->faker->optional()->sentence(), // commentaire aléatoire
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}

