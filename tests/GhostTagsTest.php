<?php

namespace Messerli90\Ghost\Tests;

use Messerli90\Ghost\Facades\Ghost;

class GhostTagsTest extends TestCase
{
    /** @test */
    public function it_sets_resource_to_tags()
    {
        $ghost = Ghost::tags();
        $this->assertEquals('tags', $ghost->resource);
    }

    /** @test */
    public function it_gets_all_tags()
    {
        $response = Ghost::tags()->all();

        $this->assertIsArray($response);
        $this->assertArrayNotHasKey('tags', $response);
        $this->assertEquals('Fables', $response[0]['name']);
        $this->assertCount(4, $response);
    }

    /** @test */
    public function it_gets_all_tags_paginate()
    {
        $response = Ghost::tags()->paginate();

        $this->assertArrayHasKey('tags', $response);
        $this->assertArrayHasKey('meta', $response);
        $this->assertEquals('Fables', $response['tags'][0]['name']);
        $this->assertCount(4, $response['tags']);
    }
}
