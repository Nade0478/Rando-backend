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
            'article_id' => $this->faker->numberBetween(1, 50),
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
            'is_favorite' => $this->faker->boolean(50), // 50% chance of being true or false
            'is_read' => $this->faker->boolean(50), // 50% chance of being true or false
            'is_shared' => $this->faker->boolean(50), // 50% chance of being true or false
            'is_liked' => $this->faker->boolean(50), // 50% chance of being true or false
            'is_bookmarked' => $this->faker->boolean(50), // 50% chance of being true or false
            'is_commented' => $this->faker->boolean(50), // 50% chance of being true or false
            'is_reported' => $this->faker->boolean(50), // 50% chance of being true or false
            'is_flagged' => $this->faker->boolean(50), // 50% chance of being true or false 
        ];
    }
}
