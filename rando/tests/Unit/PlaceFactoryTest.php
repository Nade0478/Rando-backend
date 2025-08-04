<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Place;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PlaceFactoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_a_place_with_valid_data()
    {
        $place = Place::factory()->create();

        $this->assertNotNull($place->name_place);
        $this->assertNotNull($place->description_place);
        $this->assertIsFloat($place->latitude_place);
        $this->assertIsFloat($place->longitude_place);
        $this->assertNotNull($place->image_place);
        $this->assertNotNull($place->map_place);
        $this->assertIsFloat($place->distance_place);
        $this->assertContains($place->difficulty_place, ['Facile', 'Moyen', 'Difficile']);
        $this->assertMatchesRegularExpression('/^\d{2}:\d{2}$/', $place->estimated_time_place);
    }
}
