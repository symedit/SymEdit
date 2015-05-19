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

use FOS\UserBundle\Model\UserInterface as BaseUserInterface;

interface UserInterface extends BaseUserInterface
{
    /**
     * @return int Get User ID
     */
    public function getId();

    /**
     * @return ProfileInterface Get User's Profile
     */
    public function getProfile();

    /**
     * Set user's profile.
     *
     * @param ProfileInterface $profile
     *
     * @return UserInterface
     */
    public function setProfile(ProfileInterface $profile);

    /**
     * @return bool Whether or not user is an admin
     */
    public function isAdmin();

    public function setAdmin($admin);
}
