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

  use Doctrine\Common\Persistence\ObjectManager;
  use Doctrine\Common\DataFixtures\AbstractFixture;
  use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
  use SymEdit\Bundle\CoreBundle\Model\Role;

  class LoadRoleData extends AbstractFixture implements OrderedFixtureInterface
  {
      public function load(ObjectManager $manager)
      {
          $roles = array(
              'ROLE_ADMIN'           => 'Admin Access',
              'ROLE_SUPER_ADMIN'     => 'Super Admin',
              'ROLE_ADMIN_PAGE'      => 'Page Access',
              'ROLE_ADMIN_PAGE_SEO'  => 'Page SEO Access',
              'ROLE_ADMIN_WEBMASTER' => 'Webmaster Tools Access',
              'ROLE_ADMIN_BLOG'      => 'Blog Access',
              'ROLE_ADMIN_IMAGE'     => 'Image Access',
              'ROLE_ADMIN_WIDGET'    => 'Widget Access',
              'ROLE_ADMIN_SETTING'   => 'Settings Access',
              'ROLE_ADMIN_USER'      => 'User Access',
              'ROLE_ADMIN_STYLIZER'  => 'Access to Stylizer',
          );

          foreach ($roles as $role=>$description) {
              $entity = new Role();
              $entity->setRole($role);
              $entity->setDescription($description);
              $manager->persist($entity);

              $this->addReference($role, $entity);
          }

          $manager->flush();
      }

      public function getOrder()
      {
          return 10;
      }
  }
