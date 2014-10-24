<?php

namespace SymEdit\Bundle\CoreBundle\Tests\Security;

use Symfony\Component\Security\Core\User\InMemoryUserProvider as BaseUserProvider;
use Symfony\Component\Security\Core\User\UserInterface;

class InMemoryUserProvider extends BaseUserProvider
{
    public function loadUserByUsername($username)
    {
        $coreUser = parent::loadUserByUsername($username);

        return new User($coreUser->getUsername(), $coreUser->getPassword(), $coreUser->getRoles(), $coreUser->isEnabled());
    }

    /**
     * {@inheritdoc}
     */
    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass($class)
    {
        die("checking: " . $class);
        return $class === 'SymEdit\Bundle\CoreBundle\Tests\Security\User';
    }
}
