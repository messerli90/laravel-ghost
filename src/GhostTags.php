<?php

namespace Messerli90\Ghost;

class GhostTags extends Ghost
{
    public function __construct()
    {
        parent::__construct();
        $this->resource = 'tags';
    }
}
