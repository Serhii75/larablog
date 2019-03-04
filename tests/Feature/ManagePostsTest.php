<?php

namespace Tests\Feature;

use App\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManagePostsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_can_view_posts()
    {
        $this->withoutExceptionHandling();

        $posts = factory(Post::class, 2)->create();

        $response = $this->json('GET', '/api/posts');

        $response->assertStatus(200);
    }
}
