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
use SymEdit\Bundle\CoreBundle\Model\UserInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Builder
{
    protected $container;
    protected $factory;
    protected $context;
    protected $eventDispatcher;
    protected $extensions;

    public function __construct(ContainerInterface $container, $extensions = array())
    {
        $this->factory = $container->get('knp_menu.factory');
        $this->context = $container->get('security.context');
        $this->eventDispatcher = $container->get('event_dispatcher');
        $this->container = $container;
        $this->extensions = $extensions;
    }

    /**
     * @return UserInterface $user
     */
    protected function getUser()
    {
        return $this->context->getToken()->getUser();
    }

    public function adminUserMenu()
    {
        $menu = $this->factory->createItem('root', array(
            'navbar' => true,
            'pull-right' => true,
        ));

        $user = $this->getUser();

        $userMenu = $menu->addChild('User Menu', array(
            'dropdown' => true,
            'caret' => true,
            'label' => $user->getProfile()->getFullname(),
        ));

        $userMenu->addChild('My Profile', array('route' => 'fos_user_profile_show', 'icon' => 'user'));
        $userMenu->addChild('Change Password', array('route' => 'fos_user_change_password', 'icon' => 'lock'));
        $userMenu->addChild('Logout', array('route' => 'fos_user_security_logout', 'icon' => 'off'));

        /**
         * Dispatch Menu Event
         */
        $event = new MenuEvent($menu, 'symedit_admin_user');
        $this->eventDispatcher->dispatch(Events::MENU_VIEW, $event);

        return $event->getRootNode();
    }
}
