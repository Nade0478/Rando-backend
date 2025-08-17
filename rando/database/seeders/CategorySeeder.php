<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $categories = [
        'Historique',
        'Nature et Faune',
        'Familial',
        'Aventure et Sports',
        'Économie et Culture',
        'Sciences et Techniques',
        'Gastronomique',
    ];

    foreach ($categories as $name) {
        Category::create(['name' => $name]);
    }

    // Génère 5 catégories aléatoires avec des noms uniques
    fake()->unique(true); // reset le générateur unique
    Category::factory(5)->create();
}

}

