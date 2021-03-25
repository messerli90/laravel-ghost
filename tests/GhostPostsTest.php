<?php

namespace Messerli90\Ghost\Tests;

use Illuminate\Support\Facades\Http;
use Messerli90\Ghost\GhostPosts;

class GhostPostsTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Http::fake(fn() => Http::response(file_get_contents(__DIR__ . '/fixtures/posts.json')));
    }

    /** @test */
    public function it_sets_resource_to_posts()
    {
        $ghost = new GhostPosts;
        $this->assertEquals('posts', $ghost->resource);
    }

    /** @test */
    public function it_gets_all_posts()
    {
        $response = (new GhostPosts())->all();

        $this->assertArrayHasKey('posts', $response);
        $this->assertArrayHasKey('meta', $response);
        $this->assertEquals('welcome', $response['posts'][0]['slug']);
        $this->assertCount(3, $response['posts']);
    }

    /** @test */
    public function it_handles_filters()
    {
        $ghost = (new GhostPosts())->page(4)->fields('authors', 'tags');

        $this->assertEquals($ghost->fields, 'authors,tags');
        $this->assertEquals($ghost->page, 4);
    }

    /** @test */
    public function it_returns_a_post_by_id()
    {
        $ghost = new GhostPosts();
        $response = $ghost->find('605360bbce93e1003bd6ddd6');

        // Sets resource ID
        $this->assertEquals($ghost->resourceId, '605360bbce93e1003bd6ddd6');

        // Builds Correct URL
        $expected = "https://demo.ghost.io/ghost/api/v4/content/posts/605360bbce93e1003bd6ddd6/?key=22444f78447824223cefc48062";
        $this->assertEquals($expected, $ghost->make());

        // Returns only one post
        $this->assertArrayHasKey('id', $response);
    }

    /** @test */
    public function it_returns_a_post_by_slug()
    {
        $ghost = new GhostPosts();
        $response = $ghost->fromSlug('welcome');

        // Sets resource Slug
        $this->assertEquals($ghost->resourceSlug, 'welcome');

        // Builds Correct URL
        $expected = "https://demo.ghost.io/ghost/api/v4/content/posts/slug/welcome/?key=22444f78447824223cefc48062";
        $this->assertEquals($expected, $ghost->make());

        // Returns only one post
        $this->assertArrayHasKey('slug', $response);
    }

}
