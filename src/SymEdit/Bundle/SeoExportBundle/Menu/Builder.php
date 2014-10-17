<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\SeoExportBundle\Menu;

use SymEdit\Bundle\MenuBundle\Model\MenuBuilderInterface;
use SymEdit\Bundle\MenuBundle\Model\MenuInterface;

class Builder implements MenuBuilderInterface
{
    public function buildMenu(MenuInterface $menu, array $options)
    {
        $site = $menu->getRootNode()->getChild('site');

        $site->addChild('SEO Export', array(
            'icon' => 'search',
            'route' => 'symedit_seo_export',
            'extras' => array(
                'is_granted' => 'ROLE_SUPER_ADMIN',
            ),
        ));
    }
}
