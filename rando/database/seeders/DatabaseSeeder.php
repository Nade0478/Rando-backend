<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\ArticleSeeder;
use Database\Seeders\OpinionSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\PlaceSeeder;
use Database\Seeders\At_FavoriteSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            ArticleSeeder::class,
            OpinionSeeder::class,
            PlaceSeeder::class,
            At_FavoriteSeeder::class,
        ]);

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
