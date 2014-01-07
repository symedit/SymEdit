<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Model;

use FOS\UserBundle\Model\UserInterface as BaseUserInterface;

interface UserInterface extends BaseUserInterface
{
    /**
     * @return integer Get User ID
     */
    public function getId();

    /**
     * @return ProfileInterface Get User's Profile
     */
    public function getProfile();

    /**
     * Set user's profile
     *
     * @param  \SymEdit\Bundle\CoreBundle\Model\ProfileInterface $profile
     * @return UserInterface
     */
    public function setProfile(ProfileInterface $profile);

    /**
     * @return boolean Whether or not user is an admin
     */
    public function isAdmin();

    public function setAdmin($admin);
}
