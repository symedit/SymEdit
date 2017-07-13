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

use SymEdit\Bundle\MenuBundle\Model\MenuBuilderInterface;
use SymEdit\Bundle\MenuBundle\Model\MenuInterface;

class AdminBuilder implements MenuBuilderInterface
{
    public function buildMenu(MenuInterface $menu, array $options)
    {
        $rootNode = $menu->getRootNode();

        // Dashboard
        $rootNode->addChild('dashboard', [
            'route' => 'admin_dashboard',
            'label' => 'Dashboard',
            'icon' => 'home',
        ]);

        // Content
        $content = $rootNode->addChild('content', [
            'label' => 'Content',
            'dropdown' => true,
            'caret' => true,
            'icon' => 'pencil',
            'extras' => [
                'remove_leaf' => true,
            ],
        ]);

        $pageExtras = ['is_granted' => 'ROLE_ADMIN_PAGE'];
        $content->addChild('Pages', [
            'dropdown-header' => true,
            'extras' => [
                'is_granted' => 'ROLE_ADMIN_PAGE',
                'routes' => ['route' => 'admin_page_update'],
            ],
        ]);

        $content->addChild('New Page', ['route' => 'admin_page_create', 'icon' => 'edit', 'extras' => $pageExtras]);
        $content->addChild('List Pages', ['route' => 'admin_page', 'icon' => 'file', 'extras' => $pageExtras]);

        // Media
        $rootNode->addChild('media', [
            'label' => 'Media',
            'dropdown' => true,
            'caret' => true,
            'icon' => 'image',
            'extras' => [
                'remove_leaf' => true,
            ],
        ]);

        // Structure
        $rootNode->addChild('structure', [
            'label' => 'Structure',
            'dropdown' => true,
            'caret' => true,
            'icon' => 'tasks',
            'extras' => [
                'remove_leaf' => true,
            ],
        ]);

        // Site
        $site = $rootNode->addChild('site', [
            'label' => 'Site',
            'dropdown' => true,
            'caret' => true,
            'icon' => 'cogs',
            'extras' => [
                'remove_leaf' => true,
            ],
        ]);

        $site->addChild('Settings', ['route' => 'admin_settings', 'icon' => 'cogs', 'extras' => ['is_granted' => 'ROLE_ADMIN_SETTING']]);
        $site->addChild('Users', ['route' => 'admin_user', 'icon' => 'group', 'extras' => ['is_granted' => 'ROLE_ADMIN_USER']]);
        $site->addChild('Cache', ['route' => 'admin_cache', 'icon' => 'folder-open-o']);

        // Help
        $rootNode
            ->addChild('Help', ['uri' => 'http://docs.symedit.com/guide', 'icon' => 'question-circle'])
            ->setLinkAttribute('target', '_blank');
    }
}
