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

class BlogBuilder implements MenuBuilderInterface
{
    public function buildMenu(MenuInterface $menu, array $options)
    {
        $content = $menu->getRootNode()->getChild('content');

        // Blog Heading
        $content->addChild('Blog', [
            'dropdown-header' => true,
            'extras' => [
                'is_granted' => 'ROLE_ADMIN_BLOG',
            ],
        ]);

        // New Post
        $content->addChild('New Post', [
            'route' => 'admin_post_create',
            'icon' => 'edit',
            'extras' => [
                'is_granted' => 'ROLE_ADMIN_BLOG',
            ],
        ]);

        // List Posts
        $content->addChild('List Posts', [
            'route' => 'admin_post',
            'icon' => 'th-list',
            'extras' => [
                'is_granted' => 'ROLE_ADMIN_BLOG',
            ],
        ]);

        // List Categories
        $content->addChild('List Categories', [
            'route' => 'admin_category',
            'icon' => 'tags',
            'extras' => [
                'is_granted' => 'ROLE_ADMIN_BLOG',
            ],
        ]);
    }
}
