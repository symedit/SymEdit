<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CacheBundle\Decision\Voter;

interface CacheVoterInterface
{
    const PASS = true;
    const FAIL = false;

    public function isCacheable($resource = null);
}
