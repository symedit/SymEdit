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

        $site->addChild('SEO Export', [
            'icon' => 'search',
            'route' => 'symedit_seo_export',
            'extras' => [
                'is_granted' => 'ROLE_ADMIN_WEBMASTER',
            ],
        ]);

        $site->addChild('SEO Analyze', [
            'icon' => 'check',
            'route' => 'symedit_seo_analyze',
            'extras' => [
                'is_granted' => 'ROLE_ADMIN_WEBMASTER',
            ],
        ]);
    }
}
