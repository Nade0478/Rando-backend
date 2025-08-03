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
        Category::create([
            'name' => 'Historique',
        ]);

        Category::create([
            'name' => 'Nature et Faune',
        ]);

        Category::create([
            'name' => 'Familial',
        ]);

        Category::create([
            'name' => 'Aventure et Sports',
        ]);

        Category::create([
            'name' => 'Économie et Culture',
        ]);

        Category::create([
            'name' => 'Sciences et Techniques',
        ]);

        Category::create([
            'name' => 'Gastronomique',
        ]);

        Category::create([
            'name' => 'categorie name',
        ]);

        Category::factory(5)->create();
    }
}

