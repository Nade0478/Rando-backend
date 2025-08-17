<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Image;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */


     public function definition(): array
     {
         return [
             'url' => fake()->imageUrl(640, 480, 'nature'),
             'place_id' => \App\Models\Place::inRandomOrder()->first()->id,
         ];
     }


}
