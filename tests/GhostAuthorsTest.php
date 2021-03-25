<?php

namespace Messerli90\Ghost\Tests;

use Illuminate\Support\Facades\Http;
use Messerli90\Ghost\GhostAuthors;

class GhostAuthorsTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Http::fake(fn() => Http::response(file_get_contents(__DIR__ . '/fixtures/authors.json')));
    }

    /** @test */
    public function it_sets_resource_to_authors()
    {
        $ghost = new GhostAuthors;
        $this->assertEquals('authors', $ghost->resource);
    }

    /** @test */
    public function it_gets_all_authors()
    {
        $response = (new GhostAuthors())->all();

        $this->assertArrayHasKey('authors', $response);
        $this->assertArrayHasKey('meta', $response);
        $this->assertEquals('Abraham Lincoln', $response['authors'][0]['name']);
        $this->assertCount(7, $response['authors']);
    }

}
