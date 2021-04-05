<?php

namespace Messerli90\Ghost\Tests;

use Messerli90\Ghost\Facades\Ghost;

class GhostPagesTest extends TestCase
{
    /** @test */
    public function it_sets_resource_to_pages()
    {
        $ghost = Ghost::pages();
        $this->assertEquals('pages', $ghost->resource);
    }

    /** @test */
    public function it_gets_all_pages()
    {
        $response = Ghost::pages()->all();

        $this->assertIsArray($response);
        $this->assertArrayNotHasKey('pages', $response);
        $this->assertEquals('About this site', $response[0]['title']);
        $this->assertCount(4, $response);
    }

    /** @test */
    public function it_gets_all_pages_paginated()
    {
        $response = Ghost::pages()->paginate();

        $this->assertArrayHasKey('pages', $response);
        $this->assertArrayHasKey('meta', $response);
        $this->assertEquals('About this site', $response['pages'][0]['title']);
        $this->assertCount(4, $response['pages']);
    }
}
