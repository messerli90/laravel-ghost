<?php

namespace Messerli90\Ghost;

class GhostPosts extends Ghost
{
    public function __construct()
    {
        parent::__construct();
        $this->resource = 'posts';
    }
}
