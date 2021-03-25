<?php

namespace Messerli90\Ghost\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Messerli90\Ghost\Ghost
 */
class Ghost extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-ghost';
    }
}
