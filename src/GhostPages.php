<?php

namespace Messerli90\Ghost;

class GhostPages extends Ghost
{
    public function __construct()
    {
        parent::__construct();
        $this->resource = 'pages';
    }
}
