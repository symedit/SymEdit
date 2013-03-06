<?php

  namespace Isometriks\Bundle\SymEditBundle\DataFixtures\ORM;

  use Doctrine\Common\Persistence\ObjectManager;
  use Doctrine\Common\DataFixtures\AbstractFixture;
  use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
  use Isometriks\Bundle\SymEditBundle\Entity\Role; 

  class LoadRoleData extends AbstractFixture implements OrderedFixtureInterface
  {

      public function load( ObjectManager $manager )
      {
          $roles = array(
              'ROLE_SUPER_ADMIN'     => 'Super Admin', 
              'ROLE_ADMIN'           => 'Admin Access', 
              'ROLE_ADMIN_PAGE'      => 'Page Access', 
              'ROLE_ADMIN_PAGE_SEO'  => 'Page SEO Access', 
              'ROLE_ADMIN_WEBMASTER' => 'Webmaster Tools Access',
              'ROLE_ADMIN_BLOG'      => 'Blog Access',
              'ROLE_ADMIN_IMAGE'     => 'Image Access', 
              'ROLE_ADMIN_SETTING'   => 'Settings Access',
              'ROLE_ADMIN_USER'      => 'User Access',
              'ROLE_ADMIN_EDITABLE'  => 'Live Edit Access', 
          ); 
          
          foreach($roles as $role=>$description){
              $entity = new Role(); 
              $entity->setRole($role); 
              $entity->setDescription($description); 
              $manager->persist($entity); 
              
              $this->addReference( $role, $entity ); 
          }
          
          $manager->flush(); 
      }
      
      public function getOrder()
      {
          return 10; 
      }

  }