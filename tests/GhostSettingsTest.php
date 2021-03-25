<?php

namespace Messerli90\Ghost\Tests;

use Illuminate\Support\Facades\Http;
use Messerli90\Ghost\GhostSettings;

class GhostSettingsTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Http::fake(fn() => Http::response(file_get_contents(__DIR__ . '/fixtures/settings.json')));
    }

    /** @test */
    public function it_sets_resource_to_settings()
    {
        $ghost = new GhostSettings;
        $this->assertEquals('settings', $ghost->resource);
    }

    /** @test */
    public function it_gets_all_authors()
    {
        $response = (new GhostSettings())->get();

        $this->assertArrayHasKey('settings', $response);
        $this->assertArrayHasKey('meta', $response);
        $this->assertEquals('Ghost', $response['settings']['title']);
    }

}
