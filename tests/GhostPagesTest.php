<?php

namespace Messerli90\Ghost\Tests;

use Illuminate\Support\Facades\Http;
use Messerli90\Ghost\GhostPages;

class GhostPagesTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Http::fake(fn() => Http::response(file_get_contents(__DIR__ . '/fixtures/pages.json')));
    }

    /** @test */
    public function it_sets_resource_to_pages()
    {
        $ghost = new GhostPages;
        $this->assertEquals('pages', $ghost->resource);
    }

    /** @test */
    public function it_gets_all_authors()
    {
        $response = (new GhostPages())->all();

        $this->assertArrayHasKey('pages', $response);
        $this->assertArrayHasKey('meta', $response);
        $this->assertEquals('About this site', $response['pages'][0]['title']);
        $this->assertCount(4, $response['pages']);
    }

}
