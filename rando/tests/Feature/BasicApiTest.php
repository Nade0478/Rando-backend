<?php

namespace Tests\Feature;

use Tests\TestCase;

class BasicApiTest extends TestCase
{
    /** @test */
    public function places_endpoint_returns_successful_response()
    {
        $response = $this->get('/api/places');

        $response->assertStatus(200);
    }
}
