<?php

namespace Messerli90\Ghost\Tests\Commands;

use Illuminate\Support\Facades\Cache;
use Messerli90\Ghost\Tests\TestCase;

class GhostCacheTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /** @test */
    public function it_saves_resources_to_cache()
    {
        $this->artisan('ghost:cache')
            ->assertExitCode(0);
    }

    /** @test */
    public function it_only_updates_posts_cache()
    {
        $this->artisan('ghost:cache posts')
            ->expectsOutput('Posts cached.')
            ->assertExitCode(0);

        $this->assertTrue(Cache::has('ghost_posts'));
        $this->assertTrue(array_key_exists('posts', Cache::get('ghost_posts')));
    }

    /** @test */
    public function it_only_updates_posts_and_authors_cache()
    {
        $this->artisan('ghost:cache posts authors')
            ->expectsOutput('Posts cached.')
            ->expectsOutput('Authors cached.')
            ->assertExitCode(0);

        $this->assertTrue(Cache::has('ghost_posts'));
        $this->assertTrue(Cache::has('ghost_authors'));
        $this->assertFalse(Cache::has('ghost_tags'));
        $this->assertTrue(array_key_exists('posts', Cache::get('ghost_posts')));
        $this->assertTrue(array_key_exists('authors', Cache::get('ghost_authors')));
    }
}
