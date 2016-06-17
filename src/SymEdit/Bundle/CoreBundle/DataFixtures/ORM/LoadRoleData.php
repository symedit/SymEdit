<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SymEdit\Bundle\CoreBundle\DataFixtures\AbstractFixture;
use SymEdit\Bundle\CoreBundle\Model\RoleInterface;

class LoadRoleData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $roles = [
              'ROLE_ADMIN' => 'Admin Access',
              'ROLE_SUPER_ADMIN' => 'Super Admin',
              'ROLE_ADMIN_PAGE' => 'Page Access',
              'ROLE_ADMIN_PAGE_SEO' => 'Page SEO Access',
              'ROLE_ADMIN_WEBMASTER' => 'Webmaster Tools Access',
              'ROLE_ADMIN_BLOG' => 'Blog Access',
              'ROLE_ADMIN_IMAGE' => 'Image Access',
              'ROLE_ADMIN_EVENT' => 'Event Access',
              'ROLE_ADMIN_WIDGET' => 'Widget Access',
              'ROLE_ADMIN_SETTING' => 'Settings Access',
              'ROLE_ADMIN_USER' => 'User Access',
              'ROLE_ADMIN_STYLIZER' => 'Access to Stylizer',
              'ROLE_ADMIN_FORM_BUILDER' => 'Access to Form Builder',
          ];

        foreach ($roles as $role => $description) {
            $entity = $this->createRole();
            $entity->setRole($role);
            $entity->setDescription($description);
            $manager->persist($entity);

            $this->addReference($role, $entity);
        }

        $manager->flush();
    }

    /**
     * @return RoleInterface
     */
    protected function createRole()
    {
        return $this->getFactory('role')->createNew();
    }

    public function getOrder()
    {
        return 10;
    }
}
