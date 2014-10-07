<?php

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
