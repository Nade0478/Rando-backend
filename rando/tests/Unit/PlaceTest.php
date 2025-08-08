<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Place;

class PlaceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_places()
    {
        // Arrange : créer des places en base
        Place::factory()->count(3)->create();

        // Act : appeler la route
        $response = $this->getJson('/api/places');

        // Assert : vérifier le statut et le contenu
        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }
}
