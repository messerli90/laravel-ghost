<?php

namespace Messerli90\Ghost;

use Illuminate\Support\ServiceProvider;
use Messerli90\Ghost\Commands\GhostCache;

class GhostServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/ghost.php' => config_path('ghost.php'),
            ], 'config');
            $this->commands([
                GhostCache::class
            ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->bind(Ghost::class, function () {
            [$key, $domain, $version] = $this->getConfig();
            return new Ghost($key, $domain, $version);
        });

        $this->app->alias(Ghost::class, 'laravel-ghost');
    }

    protected function getConfig()
    {
        //        throw_if(!file_exists(config_path('ghost.php')), );

        $key = config('ghost.key');
        $domain = config('ghost.admin_domain');
        $version = config('ghost.ghost_api_version');

        return [$key, $domain, $version];
    }
}
