<?php

namespace Messerli90\Ghost\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Messerli90\Ghost\Facades\Ghost;

class GhostCache extends Command
{
    public $signature = 'ghost:cache {resource?*}';

    public $description = 'Fetches new records and adds them to cache.';

    private $ttl;
    private $prefix;

    public function __construct()
    {
        parent::__construct();

        $this->ttl = config('ghost.cache.ttl', 86400);
        $this->prefix = config('ghost.cache.cache_prefix', 'ghost_');
    }

    public function handle(): void
    {
        $allowed_resources = ['posts', 'authors', 'pages', 'tags', 'settings', 'all'];
        $resources = array_filter($this->argument('resource'), fn($r) => in_array($r, $allowed_resources));

        foreach ($resources as $resource) {
            if ($resource == 'settings') {
                Cache::put($this->buildCacheKey($resource), Ghost::settings()->get(), $this->ttl);
            } else {
                Cache::put($this->buildCacheKey($resource), Ghost::setResource($resource)->all(), $this->ttl);
            }
            $this->info(ucfirst($resource) . ' cached.');
        }
    }

    private function buildCacheKey($resource): string
    {
        return $this->prefix . $resource;
    }
}
