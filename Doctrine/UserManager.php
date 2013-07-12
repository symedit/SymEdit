<?php

namespace Isometriks\Bundle\SymEditBundle\Doctrine;

use FOS\UserBundle\Doctrine\UserManager as BaseUserManager;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use FOS\UserBundle\Util\CanonicalizerInterface;
use Doctrine\Common\Persistence\ObjectManager;

class UserManager extends BaseUserManager
{
    protected $profileClass;
    protected $adminProfileClass;
    
    public function __construct(EncoderFactoryInterface $encoderFactory, 
                                CanonicalizerInterface $usernameCanonicalizer, 
                                CanonicalizerInterface $emailCanonicalizer, 
                                ObjectManager $om, 
                                $class,
                                $profileClass,
                                $adminProfileClass)
    {
        parent::__construct($encoderFactory, $usernameCanonicalizer, $emailCanonicalizer, $om, $class);
        
        $this->profileClass = $profileClass;
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