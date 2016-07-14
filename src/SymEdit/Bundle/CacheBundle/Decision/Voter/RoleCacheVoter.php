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

use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class RoleCacheVoter implements CacheVoterInterface
{
    protected $auth;
    protected $roles;

    public function __construct(AuthorizationCheckerInterface $auth, array $roles = [])
    {
        $this->auth = $auth;
        $this->roles = $roles;
    }

    public function isCacheable($resource = null)
    {
        foreach ($this->roles as $role) {
            if ($this->auth->isGranted($role)) {
                return self::FAIL;
            }
        }

        return self::PASS;
    }
}
