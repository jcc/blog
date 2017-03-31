<?php

namespace Tests\Feature\Api;

use Tests\TestCase;

class UserApiTest extends TestCase
{
    /** @test */
    public function it_shows_all_users()
    {
        $this->actingAsAdmin();
        $response = $this->get('/api/user');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => ['*' => ['id', 'name', 'avatar', 'status', 'email', 'nickname', 'is_admin', 'github_name', 'website', 'description', 'created_at']],
            'meta' => ['pagination' => []],
        ]);
    }
}
