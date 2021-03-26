<?php

namespace Messerli90\Ghost\Tests;

use Messerli90\Ghost\Facades\Ghost;

class GhostPostsTest extends TestCase
{

    /** @test */
    public function it_sets_resource_to_posts()
    {
        $ghost = Ghost::posts();
        $this->assertEquals('posts', $ghost->resource);
    }

    /** @test */
    public function it_gets_all_posts()
    {
        $response = Ghost::posts()->all();

        $this->assertArrayHasKey('posts', $response);
        $this->assertArrayHasKey('meta', $response);
        $this->assertEquals('welcome', $response['posts'][0]['slug']);
        $this->assertCount(3, $response['posts']);
    }

    /** @test */
    public function it_handles_filters()
    {
        $ghost = Ghost::posts()->page(4)->fields('authors', 'tags');

        $this->assertEquals($ghost->fields, 'authors,tags');
        $this->assertEquals($ghost->page, 4);
    }

    /** @test */
    public function it_returns_a_post_by_id()
    {
        $ghost = Ghost::posts();
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
        $ghost = Ghost::posts();
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
