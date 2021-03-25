<?php

namespace Messerli90\Ghost;

class GhostAuthors extends Ghost
{
    public function __construct()
    {
        parent::__construct();
        $this->resource = 'authors';
    }
}
