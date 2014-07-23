<?php

namespace SymEdit\Bundle\CacheBundle\Decision\Voter;

use Symfony\Component\Security\Core\SecurityContextInterface;

class RoleCacheVoter implements CacheVoterInterface
{
    protected $context;
    protected $roles;

    public function __construct(SecurityContextInterface $context, array $roles = array())
    {
        $this->context = $context;
        $this->roles = $roles;
    }

    public function isCacheable($resource = null)
    {
        foreach ($this->roles as $role) {
            if ($this->context->isGranted($role)) {
                return self::FAIL;
            }
        }

        return self::PASS;
    }
}
