<?php

namespace Isometriks\Bundle\SymEditBundle\Doctrine;

use FOS\UserBundle\Doctrine\UserManager as BaseUserManager;

class UserManager extends BaseUserManager
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
        
        $role = $admin ? 'ROLE_ADMIN' : 'ROLE_USER';
        $user->addRole($role);
        
        return $user;
    }
}