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
    protected $extensions;

    public function __construct(array $extensions = array())
    {
        $this->extensions = $extensions;
    }

    public function buildMenu(MenuInterface $menu, array $options)
    {
        $rootNode = $menu->getRootNode();

        // Dashboard
        $rootNode->addChild('dashboard', array(
            'route' => 'admin_dashboard',
            'label' => 'Dashboard',
            'icon' => 'home',
        ));

        // Content
        $content = $rootNode->addChild('content', array(
            'label' => 'Content',
            'dropdown' => true,
            'caret' => true,
            'icon' => 'pencil',
            'extras' => array(
                'remove_leaf' => true,
            ),
        ));

        $pageExtras = array('is_granted' => 'ROLE_ADMIN_PAGE');
        $content->addChild('Pages', array(
            'dropdown-header' => true,
            'extras' => array(
                'is_granted' => 'ROLE_ADMIN_PAGE',
                'routes' => array('route' => 'admin_page_update'),
            ),
        ));

        $content->addChild('New Page', array('route' => 'admin_page_create', 'icon' => 'edit', 'extras' => $pageExtras));
        $content->addChild('List Pages', array('route' => 'admin_page', 'icon' => 'file', 'extras' => $pageExtras));

        // Media
        $rootNode->addChild('media', array(
            'label' => 'Media',
            'dropdown' => true,
            'caret' => true,
            'icon' => 'image',
            'extras' => array(
                'remove_leaf' => true,
            ),
        ));

        // Structure
        $rootNode->addChild('structure', array(
            'label' => 'Structure',
            'dropdown' => true,
            'caret' => true,
            'icon' => 'tasks',
            'extras' => array(
                'remove_leaf' => true,
            ),
        ));

        // Site
        $site = $rootNode->addChild('site', array(
            'label' => 'Site',
            'dropdown' => true,
            'caret' => true,
            'icon' => 'cogs',
            'extras' => array(
                'remove_leaf' => true,
            ),
        ));

        $site->addChild('Settings', array('route' => 'admin_settings', 'icon' => 'cogs', 'extras' => array('is_granted' => 'ROLE_ADMIN_SETTING')));
        $site->addChild('Users', array('route' => 'admin_user', 'icon' => 'group', 'extras' => array('is_granted' => 'ROLE_ADMIN_USER')));

        // Extensions
        $extensions = $rootNode->addChild('Extensions', array(
            'dropdown' => true,
            'caret' => true,
            'extras' => array(
                'remove_leaf' => true,
            ),
        ));

        $index = 0;
        foreach ($this->extensions as $extension) {
            $extensions->addChild(sprintf('extension_%d', $index++), $extension);
        }

        // Help
        $rootNode
            ->addChild('Help', array('uri' => 'http://docs.symedit.com/guide', 'icon' => 'question-circle'))
            ->setLinkAttribute('target', '_blank');
    }
}
