<?php

namespace SymEdit\Bundle\CoreBundle\Model;

interface ProfileInterface
{
    /**
     * @return integer Profile ID
     */
    public function getId();

    /**
     * Set user's first name
     *
     * @param  string           $firstName
     * @return ProfileInterface
     */
    public function setFirstName($firstName);

    /**
     * @return string User's first name
     */
    public function getFirstName();

    /**
     * Set User's last name
     *
     * @param  string           $lastName
     * @return ProfileInterface
     */
    public function setLastName($lastName);

    /**
     * @return string User's last name
     */
    public function getLastName();

    /**
     * @return string User's full name
     */
    public function getFullname();

    /**
     * @return \SymEdit\Bundle\CoreBundle\Model\UserInterface Return the user that this profile is for
     */
    public function getUser();
}
