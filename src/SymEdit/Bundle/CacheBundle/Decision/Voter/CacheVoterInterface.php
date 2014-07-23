<?php

namespace SymEdit\Bundle\CacheBundle\Decision\Voter;

interface CacheVoterInterface
{
    const PASS = true;
    const FAIL = false;

    public function isCacheable($resource = null);
}