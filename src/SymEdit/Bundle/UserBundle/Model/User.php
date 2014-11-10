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
        $this->profile->setUser($this);

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
