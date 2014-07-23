<?php

namespace SymEdit\Bundle\CacheBundle\Decision;

class CacheDecisionManager
{
    protected $voters;

    public function __construct(array $voters = array())
    {
        $this->voters = $voters;
    }

    public function decide($resource = null)
    {
        foreach ($this->voters as $voter) {
            if (!$voter->isCacheable($resource)) {
                return false;
            }
        }

        return true;
    }
}
