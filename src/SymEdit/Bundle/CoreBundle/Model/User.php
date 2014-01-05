<?php

namespace SymEdit\Bundle\CoreBundle\Model;

use SymEdit\Bundle\CoreBundle\Model\UserInterface;
use SymEdit\Bundle\CoreBundle\Model\ProfileInterface;
use FOS\UserBundle\Model\User as BaseUser;

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
