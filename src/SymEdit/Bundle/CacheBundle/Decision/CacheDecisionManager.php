<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CacheBundle\Decision;

class CacheDecisionManager
{
    protected $voters;

    public function __construct(array $voters = [])
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
