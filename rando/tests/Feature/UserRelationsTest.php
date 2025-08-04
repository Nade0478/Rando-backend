<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Favorite;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRelationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_can_have_multiple_favorites()
    {
        $user = User::factory()->create();
        $favorites = collect();

        for ($i = 0; $i < 3; $i++) {
            $favorite = Favorite::factory()->create();
            $user->favorites()->attach($favorite->id);
            $favorites->push($favorite);
        }

        $user->load('favorites');

        $this->assertCount(3, $user->favorites);
        $this->assertEquals(
            $favorites->pluck('id')->sort()->values(),
            $user->favorites->pluck('id')->sort()->values()
        );
    }
}
