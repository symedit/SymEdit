<?php

namespace Isometriks\Bundle\SymEditBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {

    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $user_manager = $this->container->get('fos_user.user_manager');

        $user_admin = $user_manager->createUser();
        $user_admin->setUsername('admin');
        $user_admin->setFirstName('Admin');
        $user_admin->setPlainPassword('test'); 
        $user_admin->setEmail('youremail@domain.com');
        $user_admin->setEnabled(true); 
        $user_admin->addRole($manager->merge($this->getReference('ROLE_SUPER_ADMIN')));

        $user_manager->updateUser($user_admin);

        $this->addReference('user-admin', $user_admin);

        $manager->flush();
    }

    public function getOrder()
    {
        return 15;
    }

}