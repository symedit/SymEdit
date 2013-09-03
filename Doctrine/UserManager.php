<?php

namespace Isometriks\Bundle\SymEditBundle\Doctrine;

use FOS\UserBundle\Doctrine\UserManager as BaseUserManager;
use Isometriks\Bundle\SymEditBundle\Model\UserManagerInterface;

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

    public function createUser($admin = false)
    {
        $user = parent::createUser();
        $user->setProfile($this->createProfile($admin));
        $user->setAdmin($admin);

        $role = $admin ? 'ROLE_ADMIN' : 'ROLE_USER';
        $user->addRole($role);

        return $user;
    }

    public function findProfileBy(array $criteria)
    {
        return $this->objectManager->getRepository($this->profileClass)->findOneBy($criteria);
    }

    public function findAdminProfileBy(array $criteria)
    {
        return $this->objectManager->getRepository($this->adminProfileClass)->findOneBy($criteria);
    }

    public function findAdmins()
    {
        return $this->repository->findBy(array('admin' => true));
    }

    public function findAdminBy(array $criteria)
    {
        $criteria['admin'] = true;

        return $this->findUserBy($criteria);
    }
}