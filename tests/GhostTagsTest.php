<?php

namespace Messerli90\Ghost\Tests;

use Illuminate\Support\Facades\Http;
use Messerli90\Ghost\GhostTags;

class GhostTagsTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Http::fake(fn() => Http::response(file_get_contents(__DIR__ . '/fixtures/tags.json')));
    }

    /** @test */
    public function it_sets_resource_to_tags()
    {
        $ghost = new GhostTags;
        $this->assertEquals('tags', $ghost->resource);
    }

    /** @test */
    public function it_gets_all_authors()
    {
        $response = (new GhostTags())->all();

        $this->assertArrayHasKey('tags', $response);
        $this->assertArrayHasKey('meta', $response);
        $this->assertEquals('Fables', $response['tags'][0]['name']);
        $this->assertCount(4, $response['tags']);
    }

}
