<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\UserBundle\Tests\Model;

use SymEdit\Bundle\UserBundle\Model\Profile;
use SymEdit\Bundle\UserBundle\Model\ProfileInterface;
use SymEdit\Bundle\UserBundle\Tests\TestCase;

class ProfileTest extends TestCase
{
    /**
     * @return ProfileInterface
     */
    protected function createProfile()
    {
        return new Profile();
    }

    public function testGetFullname()
    {
        $profile = $this->createProfile()
                        ->setFirstName('John')
                        ->setLastName('Doe');

        // Test Both Names
        $this->assertEquals('John Doe', $profile->getFullname());

        // Test Missing last name, no space
        $profile->setLastName('');

        $this->assertEquals('John', $profile->getFullname());

        // Test Missing first name
        $profile->setFirstName('')
                ->setLastName('Doe');

        $this->assertEquals('Doe', $profile->getFullname());
    }
}
