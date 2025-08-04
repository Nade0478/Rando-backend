<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Favorite;

class FavoriteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Favorite::factory()->count(50)->create();
    }
}
