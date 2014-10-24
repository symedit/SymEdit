<?php

namespace SymEdit\Bundle\CoreBundle\Tests\Security;

use SymEdit\Bundle\CoreBundle\Model\Profile;
use SymEdit\Bundle\CoreBundle\Model\User as BaseUser;

class User extends BaseUser
{
    public function __construct($username, $password, array $roles = array(), $enabled = true)
    {
        $this->setUsername($username);
        $this->setPassword($password);
        $this->setRoles($roles);
        $this->setEnabled($enabled);

        $profile = new Profile();
        $profile->setFirstName('Test');
        $profile->setLastName('User');

        $this->setProfile($profile);
    }
}
