<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Place;

class PlaceSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::inRandomOrder()->first(); // récupère un utilisateur existant

        Place::create([
            'name_place' => 'Place 1',
            'longitude_place' => 45.80,
            'latitude_place' => 4.87,
            'description_place' => 'Description de la place 1',
            'image_place' => 'place1.jpg',
            'map_place' => 'place1_map.jpg',
            'distance_place' => 10,
            'difficulty_place' => 'Facile',
            'estimated_time_place' => '08:00',
            'user_id' => $user->id, // ← ici
        ]);
    }
}
