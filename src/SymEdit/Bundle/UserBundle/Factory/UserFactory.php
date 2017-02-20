<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\UserBundle\Factory;

use SymEdit\Bundle\UserBundle\Model\UserInterface;
use SymEdit\Bundle\UserBundle\Model\UserManagerInterface;

class UserFactory implements UserFactoryInterface
{
    private $userManager;

    public function __construct(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * @return UserInterface
     */
    public function createNew()
    {
        return $this->userManager->createUser();
    }

    public function createAdmin()
    {
        $user = $this->userManager->createUser(true);
        $user->setEnabled(true);

        return $user;
    }
}
