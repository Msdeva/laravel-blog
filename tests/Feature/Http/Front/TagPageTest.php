<?php

namespace Wingsline\Blog\Tests\Feature\Http\Front;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Wingsline\Blog\Posts\Post;
use Wingsline\Blog\Tests\TestCase;

class TagPageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @covers \Wingsline\Blog\Http\Controllers\Front\TaggedPostsController::__invoke()
     */
    public function testIt_shows_the_tagged_posts()
    {
        $post = factory(Post::class)
            ->create([
                'title' => 'foo-title',
                'published' => 1,
            ]);
        $post->syncTags(['foo', 'bar']);
        factory(Post::class)
            ->create([
                'title' => 'bar-title',
                'published' => 1,
            ]);

        $response = $this->get('/blog/tag/foo');

        $response->assertStatus(200);
        $response->assertSee('foo-title');
        $response->assertDontSee('bar-title');
    }
}
