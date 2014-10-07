<?php

namespace SymEdit\Bridge\Blog\Menu;

use SymEdit\Bundle\MenuBundle\Model\MenuBuilderInterface;
use SymEdit\Bundle\MenuBundle\Model\MenuInterface;

class Builder implements MenuBuilderInterface
{
    public function buildMenu(MenuInterface $menu, array $options)
    {
        $content = $menu->getRootNode()->getChild('content');

        $content->addChild('Blog', array('dropdown-header' => true, 'extras' => array('is_granted' => 'ROLE_ADMIN_BLOG')));
        $content->addChild('New Post', array('route' => 'admin_post_create', 'icon' => 'edit', 'extras' => array('is_granted' => 'ROLE_ADMIN_BLOG')));
        $content->addChild('List Posts', array('route' => 'admin_post', 'icon' => 'th-list', 'extras' => array('is_granted' => 'ROLE_ADMIN_BLOG')));
        $content->addChild('List Categories', array('route' => 'admin_category', 'icon' => 'tags', 'extras' => array('is_granted' => 'ROLE_ADMIN_BLOG')));
    }
}
