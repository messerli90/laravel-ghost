<?php

namespace Messerli90\Ghost\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Http;
use Messerli90\Ghost\Ghost;
use Messerli90\Ghost\GhostServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn(string $modelName) => 'Messerli90\\Ghost\\Database\\Factories\\' . class_basename($modelName) . 'Factory'
        );

        Http::fake([
            '*authors*' => Http::response(file_get_contents(__DIR__ . '/fixtures/authors.json'), 200),
            '*posts*' => Http::response(file_get_contents(__DIR__ . '/fixtures/posts.json'), 200),
            '*tags*' => Http::response(file_get_contents(__DIR__ . '/fixtures/tags.json'), 200),
            '*pages*' => Http::response(file_get_contents(__DIR__ . '/fixtures/pages.json'), 200),
            '*settings*' => Http::response(file_get_contents(__DIR__ . '/fixtures/settings.json'), 200),
        ]);
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $app['config']->set('ghost.ghost_api_version', '4');
        $app['config']->set('ghost.admin_domain', 'https://demo.ghost.io');
        $app['config']->set('ghost.key', '22444f78447824223cefc48062');
        $app['config']->set('ghost.cache.cache_records', false);
        $app['config']->set('ghost.cache.cache_prefix', 'ghost_');
        $app['config']->set('ghost.cache.ttl', 3600);

        /*
        include_once __DIR__.'/../database/migrations/create_laravel_ghost_table.php.stub';
        (new \CreatePackageTable())->up();
        */
    }

    protected function getPackageProviders($app)
    {
        return [
            GhostServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Ghost' => Ghost::class
        ];
    }
}
