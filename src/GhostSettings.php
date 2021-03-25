<?php

namespace Messerli90\Ghost;

class GhostSettings extends Ghost
{
    public function __construct()
    {
        parent::__construct();
        $this->resource = 'settings';
    }
}
