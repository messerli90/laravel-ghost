<?php

namespace Messerli90\Ghost\Commands;

use Illuminate\Console\Command;

class GhostCommand extends Command
{
    //TODO: Could add a "update cache" command
    public $signature = 'laravel-ghost';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
