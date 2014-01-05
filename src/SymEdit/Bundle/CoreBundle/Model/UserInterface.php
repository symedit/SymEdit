<?php

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
