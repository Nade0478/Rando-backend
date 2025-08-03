<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\At_Favorite;

class At_FavoriteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        At_Favorite::factory()->count(50)->create();
    }
}
