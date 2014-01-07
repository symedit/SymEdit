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

use FOS\UserBundle\Model\UserManagerInterface as BaseManager;
use Symfony\Component\Security\Core\User\UserProviderInterface;

interface UserManagerInterface extends UserProviderInterface, BaseManager
{
    public function setProfileClass($profileClass);
    public function setAdminProfileClass($adminProfileClass);

    /**
     * Creates a new profile
     *
     * @return ProfileInterface $profile
     */
    public function createProfile($admin = false);

    /**
     * Creates a new user
     *
     * @return UserInterface $user
     */
    public function createUser($admin = false);

    /**
     * Find regular user profile by
     *
     * @return ProfileInterface|null $profile
     */
    public function findProfileBy(array $criteria);

    /**
     * Find regular user profiles by
     *
     * @return ProfileInterface
     */
    public function findProfilesBy(array $criteria);

    /**
     * Find admin profile by
     *
     * @return ProfileInterface|null $adminProfile
     */
    public function findAdminProfileBy(array $criteria);

    /**
     * Find admin profiles by
     *
     * @return ProfileInterface
     */
    public function findAdminProfilesBy(array $criteria);

    /**
     * Find one admin by criteria
     */
    public function findAdminBy(array $criteria);

    public function findAdmins();
}
