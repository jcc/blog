<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ArticleApiTest extends TestCase
{
    /** @test */
    public function it_shows_all_articles()
    {
        $this->actingAsAdmin();
        $response = $this->get('api/article');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => ['*' => ['id', 'title', 'subtitle', 'user', 'slug', 'content', 'page_image', 'meta_description', 'is_original', 'is_draft', 'visitors', 'published_at', 'published_time']],
            'meta' => ['pagination' => []],
        ]);
    }

    /** @test */
    public function it_shows_article()
    {
        
    }
}
