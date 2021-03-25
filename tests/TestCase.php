<?php

namespace Messerli90\Ghost\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Messerli90\Ghost\Ghost;
use Orchestra\Testbench\TestCase as Orchestra;
use Messerli90\Ghost\GhostServiceProvider;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Messerli90\\Ghost\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
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

        /*
        include_once __DIR__.'/../database/migrations/create_laravel_ghost_table.php.stub';
        (new \CreatePackageTable())->up();
        */
    }
}
