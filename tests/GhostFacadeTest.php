<?php

namespace Messerli90\Ghost\Tests;

use Ghost;
use Illuminate\Support\Facades\Http;

class GhostFacadeTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Http::fake(fn() => Http::response(file_get_contents(__DIR__ . '/fixtures/pages.json')));
    }

    /** @test */
    public function it_initializes_by_config()
    {
        dd(Ghost::find('something'));
    }
}
