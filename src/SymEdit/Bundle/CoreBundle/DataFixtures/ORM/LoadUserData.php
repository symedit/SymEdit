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

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $user_manager = $this->container->get('fos_user.user_manager');

        $user_admin = $user_manager->createUser(true);
        $user_admin
            ->setUsername('admin')
            ->setPlainPassword('test')
            ->setEmail('youremail@domain.com')
            ->setEnabled(true)
            ->addRole($manager->merge($this->getReference('ROLE_SUPER_ADMIN')))
            ->getProfile()
                ->setFirstName('Admin');

        $user_manager->updateUser($user_admin);

        $this->addReference('user-admin', $user_admin);

        $manager->flush();
    }

    public function getOrder()
    {
        return 15;
    }
}
