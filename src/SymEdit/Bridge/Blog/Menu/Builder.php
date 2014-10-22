<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bridge\Blog\Menu;

use SymEdit\Bundle\MenuBundle\Model\MenuBuilderInterface;
use SymEdit\Bundle\MenuBundle\Model\MenuInterface;

class Builder implements MenuBuilderInterface
{
    public function buildMenu(MenuInterface $menu, array $options)
    {
        $content = $menu->getRootNode()->getChild('content');

        // Blog Heading
        $content->addChild('Blog', array(
            'dropdown-header' => true,
            'extras' => array(
                'is_granted' => 'ROLE_ADMIN_BLOG',
            ),
        ));

        // New Post
        $content->addChild('New Post', array(
            'route' => 'admin_post_create',
            'icon' => 'edit',
            'extras' => array(
                'is_granted' => 'ROLE_ADMIN_BLOG',
            ),
        ));

        // List Posts
        $content->addChild('List Posts', array(
            'route' => 'admin_post',
            'icon' => 'th-list',
            'extras' => array(
                'is_granted' => 'ROLE_ADMIN_BLOG',
            ),
        ));
        
        // List Categories
        $content->addChild('List Categories', array(
            'route' => 'admin_category',
            'icon' => 'tags',
            'extras' => array(
                'is_granted' => 'ROLE_ADMIN_BLOG',
            ),
        ));
    }
}
