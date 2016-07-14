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

use Sylius\Component\Resource\Model\ResourceInterface;

interface ProfileInterface extends ResourceInterface
{
    /**
     * @return int Profile ID
     */
    public function getId();

    /**
     * Set user's first name.
     *
     * @param string $firstName
     *
     * @return ProfileInterface
     */
    public function setFirstName($firstName);

    /**
     * @return string User's first name
     */
    public function getFirstName();

    /**
     * Set User's last name.
     *
     * @param string $lastName
     *
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
     * @return UserInterface Return the user that this profile is for
     */
    public function getUser();

    /**
     * @param UserInterface
     *
     * @return ProfileInterface
     */
    public function setUser(UserInterface $user);
}
