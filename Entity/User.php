<?php

namespace Isometriks\Bundle\SymEditBundle\Entity;

use Isometriks\Bundle\SymEditBundle\Model\UserInterface;
use Isometriks\Bundle\SymEditBundle\Model\ProfileInterface;
use FOS\UserBundle\Entity\User as BaseUser;

class User extends BaseUser implements UserInterface
{
    protected $id;
    protected $profile;
    protected $admin;

    public function getId()
    {
        return $this->id;
    }

    public function getProfile()
    {
        return $this->profile;
    }

    public function setProfile(ProfileInterface $profile)
    {
        $this->profile = $profile;

        return $this;
    }

    public function isAdmin()
    {
        return $this->admin;
    }

    public function setAdmin($admin)
    {
        $this->admin = $admin;

        return $this;
    }
}