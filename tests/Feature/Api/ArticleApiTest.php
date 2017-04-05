<?php

namespace Tests\Feature\Api;

use Tests\TestCase;

class ArticleApiTest extends TestCase
{
    /** @test */
    public function it_shows_all_articles()
    {
        $response = $this->actingAsAdmin()->get('api/article');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => ['*' => ['id', 'title', 'subtitle', 'user', 'slug', 'content', 'page_image', 'meta_description', 'is_original', 'is_draft', 'visitors', 'published_at', 'published_time']],
            'meta' => ['pagination' => []],
        ]);
    }

    /** @test */
    public function it_shows_a_article()
    {
        $article = factory(\App\Article::class, 1)->create()->first();
        $response = $this->actingAsAdmin()->get(route('api.article.edit', $article->id));

        $response->assertStatus(200);
    }

    /** @test */
    public function it_store_a_article()
    {
        $article = factory(\App\Article::class)->make();

        $data = array_merge($article->toArray(), [ 'tags' => '[1, 2]' ]);

        $response = $this->actingAsAdmin()->post(route('api.article.store', $data));

        $response->assertStatus(204);
    }
}
