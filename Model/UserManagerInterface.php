<?php

namespace Isometriks\Bundle\SymEditBundle\Model;

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
     * Find admin profile by
     *
     * @return ProfileInterface|null $adminProfile
     */
    public function findAdminProfileBy(array $criteria);

    /**
     * Find one admin by criteria
     */
    public function findAdminBy(array $criteria);

    public function findAdmins();
}