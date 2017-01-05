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

use FOS\UserBundle\Model\UserManagerInterface as BaseManager;

interface UserManagerInterface extends BaseManager
{
    public function setProfileClass($profileClass);
    public function setAdminProfileClass($adminProfileClass);

    /**
     * Creates a new profile.
     *
     * @return ProfileInterface $profile
     */
    public function createProfile($admin = false);

    /**
     * Creates a new user.
     *
     * @return UserInterface $user
     */
    public function createUser($admin = false);
}
