<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\UserBundle\Model;

use FOS\UserBundle\Doctrine\UserManager as BaseUserManager;

class UserManager extends BaseUserManager implements UserManagerInterface
{
    protected $profileClass;
    protected $adminProfileClass;

    public function setProfileClass($profileClass)
    {
        $this->profileClass = $profileClass;
    }

    public function setAdminProfileClass($adminProfileClass)
    {
        $this->adminProfileClass = $adminProfileClass;
    }

    public function createProfile($admin = false)
    {
        $profileClass = $admin ? $this->adminProfileClass : $this->profileClass;

        $profile = new $profileClass();

        return $profile;
    }

    /**
     * @return UserInterface
     */
    public function createUser($admin = false)
    {
        $user = parent::createUser();
        $user->setProfile($this->createProfile($admin));
        $user->setAdmin($admin);

        $role = $admin ? 'ROLE_ADMIN' : 'ROLE_USER';
        $user->addRole($role);

        return $user;
    }
}
