<?php

namespace Isometriks\Bundle\SymEditBundle\Menu;

use Isometriks\Bundle\SymEditBundle\Event\Events;
use Isometriks\Bundle\SymEditBundle\Event\MenuEvent;
use Isometriks\Bundle\SymEditBundle\Model\UserInterface;
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

    public function adminMenu()
    {
        $menu = $this->factory->createItem('root', array(
            'navbar' => true,
        ));

        if (!$this->context->isGranted('ROLE_ADMIN')) {
            return $menu;
        }

        $dashboard = $menu->addChild('dashboard', array('route' => 'admin_dashboard', 'label' => 'Dashboard', 'icon' => 'home'));
        $content = $menu->addChild('Content', array('dropdown' => true, 'caret' => true, 'icon' => 'pencil'));

        /**
         * Pages
         */
        if ($this->context->isGranted('ROLE_ADMIN_PAGE')) {
            $content->addChild('Pages', array('dropdown-header' => true));
            $content->addChild('New Page', array('route' => 'admin_page_create', 'icon' => 'edit'));
            $content->addChild('List Pages', array('route' => 'admin_page', 'icon' => 'file'));
        }

        /**
         * Blog
         */
        if ($this->context->isGranted('ROLE_ADMIN_BLOG')) {
            $content->addChild('Blog', array('dropdown-header' => true));
            $content->addChild('New Post', array('route' => 'admin_post_create', 'icon' => 'edit'));
            $content->addChild('List Posts', array('route' => 'admin_post', 'icon' => 'th-list'));
            $content->addChild('List Categories', array('route' => 'admin_category', 'icon' => 'tags'));
        }

        /**
         * Images
         */
        if ($this->context->isGranted('ROLE_ADMIN_IMAGE')) {
            $media = $menu->addChild('Media', array('dropdown' => true, 'caret' => true, 'icon' => 'picture'));
            $media->addChild('View Images', array('route' => 'admin_image', 'icon' => 'picture'));
            $media->addChild('Upload Image', array('route' => 'admin_image_create', 'icon' => 'upload'));
            $media->addChild('Sliders', array('route' => 'admin_image_slider', 'icon' => 'film'));
        }


        /**
         * Widgets
         */
        if ($this->context->isGranted('ROLE_ADMIN_WIDGET')) {
            $structure = $menu->addChild('Structure', array('dropdown' => true, 'caret' => true, 'icon' => 'tasks'));
            $structure->addChild('Widgets', array('dropdown-header' => true));
            $structure->addChild('New Widget', array('route' => 'admin_widget_choose', 'icon' => 'edit'));
            $structure->addChild('List Widgets', array('route' => 'admin_widget', 'icon' => 'tasks'));
        }

        /**
         * Site
         */
        $settings = $this->context->isGranted('ROLE_ADMIN_SETTING');
        $users = $this->context->isGranted('ROLE_ADMIN_USER');
        $stylizer = $this->context->isGranted('ROLE_ADMIN_STYLIZER') && $this->container->has('isometriks_stylizer.stylizer');

        if ($settings || $users || $stylizer) {
            $site = $menu->addChild('Site', array('dropdown' => true, 'caret' => true, 'icon' => 'wrench'));

            if ($settings) {
                $site->addChild('Settings', array('route' => 'admin_settings', 'icon' => 'cogs'));
            }

            if ($users) {
                $site->addChild('Users', array('route' => 'admin_user', 'icon' => 'group'));
            }

            if ($stylizer) {
                $site->addChild('Stylizer', array('route' => 'admin_stylizer', 'icon' => 'magic'));
            }
        }


        /**
         * Extensions
         */
        $validExtensions = array_filter($this->extensions, function($extension) {
            return !isset($extension['role']) || $this->context->isGranted($extension['role']);
        });

        if (count($validExtensions) > 0) {
            $extensions = $menu->addChild('Extensions', array(
                'dropdown' => true,
                'caret' => true,
            ));

            $index = 0;
            foreach ($this->extensions as $extension) {
                $extensions->addChild('extension_'.$index++, $extension);
            }
        }

        /**
         * Dispatch Menu Event
         */
        $event = new MenuEvent($menu, 'symedit_admin');
        $this->eventDispatcher->dispatch(Events::MENU_VIEW, $event);

        return $event->getRootNode();
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