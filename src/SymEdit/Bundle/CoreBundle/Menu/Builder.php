<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Menu;

use SymEdit\Bundle\CoreBundle\Event\Events;
use SymEdit\Bundle\CoreBundle\Event\MenuEvent;
use SymEdit\Bundle\UserBundle\Model\UserInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Builder
{
    protected $factory;
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->factory = $container->get('knp_menu.factory');
        $this->container = $container;
    }

    /**
     * @return UserInterface $user
     */
    protected function getUser()
    {
        return $this->container->get('security.token_storage')->getToken()->getUser();
    }

    public function adminUserMenu()
    {
        $menu = $this->factory->createItem('root', [
            'navbar' => true,
            'pull-right' => true,
        ]);

        $user = $this->getUser();

        $userMenu = $menu->addChild('User Menu', [
            'dropdown' => true,
            'caret' => true,
            'label' => $user->getProfile()->getFullname(),
        ]);

        $userMenu->addChild('My Profile', [
            'label' => 'symedit.security.profile',
            'route' => 'fos_user_profile_show',
            'icon' => 'user',
        ]);

        $userMenu->addChild('Change Password', [
            'label' => 'symedit.security.change_password',
            'route' => 'fos_user_change_password',
            'icon' => 'lock',
        ]);

        $userMenu->addChild('Logout', [
            'label' => 'symedit.security.logout',
            'route' => 'fos_user_security_logout',
            'icon' => 'power-off',
        ]);

        /*
         * Dispatch Menu Event
         */
        $event = new MenuEvent($menu, 'symedit_admin_user');
        $this->container->get('event_dispatcher')->dispatch(Events::MENU_VIEW, $event);

        return $event->getRootNode();
    }
}
