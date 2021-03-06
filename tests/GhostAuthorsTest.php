<?php

namespace Messerli90\Ghost\Tests;

use Messerli90\Ghost\Facades\Ghost;

class GhostAuthorsTest extends TestCase
{
    /** @test */
    public function it_sets_resource_to_authors()
    {
        $ghost = Ghost::authors();
        $this->assertEquals('authors', $ghost->resource);
    }

    /** @test */
    public function it_gets_all_authors()
    {
        $response = Ghost::authors()->get();

        $this->assertIsArray($response);
        $this->assertArrayNotHasKey('authors', $response);
        $this->assertEquals('Abraham Lincoln', $response[0]['name']);
        $this->assertCount(7, $response);
    }

    /** @test */
    public function it_gets_all_authors_paginated()
    {
        $response = Ghost::authors()->paginate();

        $this->assertArrayHasKey('authors', $response);
        $this->assertArrayHasKey('meta', $response);
        $this->assertEquals('Abraham Lincoln', $response['authors'][0]['name']);
        $this->assertCount(7, $response['authors']);
    }
}
