<?php

namespace Messerli90\Ghost\Tests;

use Messerli90\Ghost\Facades\Ghost;

class GhostSettingsTest extends TestCase
{
    /** @test */
    public function it_sets_resource_to_settings()
    {
        $ghost = Ghost::settings();
        $this->assertEquals('settings', $ghost->resource);
    }

    /** @test */
    public function it_gets_all_authors()
    {
        $response = Ghost::settings()->get();

        $this->assertIsArray($response);
        $this->assertEquals('Ghost', $response['title']);
    }
}
