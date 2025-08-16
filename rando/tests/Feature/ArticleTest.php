<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Article;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_a_list_of_articles()
    {
        // Arrange : créer des articles fictifs
        Article::factory()->count(3)->create();

        // Act : appeler la route API avec le bon header
        $response = $this->getJson('/api/articles');

        // Assert : vérifier le code, le type et le contenu
        $response->assertStatus(200)
                 ->assertHeader('Content-Type', 'application/json')
                 ->assertJsonCount(3) // on attend 3 articles
                 ->assertJsonStructure([
                     '*' => [ // chaque article doit avoir ces champs
                         'id',
                         'title',
                         'content',
                         'category_id',
                         'created_at',
                         'updated_at',
                     ]
                 ]);
    }
}
