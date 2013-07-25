<?php

namespace Isometriks\Bundle\SymEditBundle\Model;

interface UserInterface
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
     * @param \Isometriks\Bundle\SymEditBundle\Model\ProfileInterface $profile
     * @return UserInterface
     */
    public function setProfile(ProfileInterface $profile);

    public function getAdmin();

    public function setAdmin($admin);
}