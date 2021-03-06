<?php

namespace Messerli90\Ghost\Tests;

use Messerli90\Ghost\Facades\Ghost;

class GhostTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /** @test */
    public function it_initializes_by_config()
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function it_builds_uri()
    {
        $expected = 'https://demo.ghost.io/ghost/api/v4/content/posts/?key=22444f78447824223cefc48062';
        $this->assertEquals(Ghost::make('posts'), $expected);
    }

    /** @test */
    public function it_sets_includes()
    {
        $authors = Ghost::with('authors');
        $this->assertEquals('authors', $authors->includes);

        $authorsTags = Ghost::with('authors', 'tags');
        $this->assertEquals('authors,tags', $authorsTags->includes);

        $counts = Ghost::with('count.posts');
        $this->assertEquals('count.posts', $counts->includes);
    }

    /** @test */
    public function it_sets_includes_from_array()
    {
        $authorsTags = Ghost::with(['authors', 'tags']);
        $this->assertEquals('authors,tags', $authorsTags->includes);
    }

    /** @test */
    public function it_sets_fields()
    {
        $ghost = Ghost::fields('title', 'url');
        $this->assertEquals('title,url', $ghost->fields);
    }

    /** @test */
    public function it_sets_format()
    {
        $ghost = Ghost::format('plaintext');
        $this->assertEquals('plaintext', $ghost->formats);
    }

    /** @test */
    public function it_sets_limit()
    {
        $ghost = Ghost::limit(5);
        $this->assertEquals(5, $ghost->limit);
    }

    /** @test */
    public function it_sets_page()
    {
        $ghost = Ghost::page(2);
        $this->assertEquals(2, $ghost->page);
    }

    /** @test */
    public function it_sets_order()
    {
        $ghost = Ghost::orderBy('published_at');
        $this->assertEquals('published_at%20desc', $ghost->order);

        $ghost = Ghost::orderBy('published_at', 'asc');
        $this->assertEquals('published_at%20asc', $ghost->order);
    }

    /** @test */
    public function it_explicitly_sets_resource()
    {
        $ghost = Ghost::setResource('tags');
        $this->assertEquals('tags', $ghost->resource);
    }

    /** @test */
    public function it_can_chain_filters()
    {
        $ghost = Ghost::with('authors', 'tags')
            ->fields('title', 'url')
            ->format('plaintext')
            ->limit(5)
            ->page(2);

        $this->assertEquals('authors,tags', $ghost->includes);
        $this->assertEquals('title,url', $ghost->fields);
        $this->assertEquals('plaintext', $ghost->formats);
        $this->assertEquals(5, $ghost->limit);
        $this->assertEquals(2, $ghost->page);

        $expected = "https://demo.ghost.io/ghost/api/v4/content/posts/?key=22444f78447824223cefc48062&include=authors%2Ctags&fields=title%2Curl&formats=plaintext&limit=5&page=2";
        $uri = $ghost->make();
        $this->assertEquals($expected, $uri);
    }

    /** @test */
    public function it_returns_empty_array_when_resource_not_found()
    {
        $notfound = Ghost::posts()->fromSlug('nonsense-slug');

        $this->assertEquals([], $notfound);
    }

    /** @test */
    public function it_returns_resource_and_meta_when_using_paginate()
    {
        $posts = Ghost::posts()->paginate();

        $this->assertArrayHasKey('posts', $posts);
        $this->assertArrayHasKey('meta', $posts);
    }

    /** @test */
    public function it_returns_empty_array_as_resource_and_meta_when_using_paginate_and_failing()
    {
        $ghost = Ghost::posts();
        $ghost->resourceSlug = 'nonsense';
        $posts = $ghost->paginate();

        ray($posts);
        $this->assertEquals($posts, ['posts' => []]);
        $this->assertArrayHasKey('posts', $posts);
        $this->assertArrayNotHasKey('meta', $posts);
    }

    /** @test */
    public function it_returns_correct_limit_with_paginated_results()
    {
        $ghost = Ghost::posts();
        $ghost->paginate(7);

        $this->assertEquals(7, $ghost->limit);
    }
}
