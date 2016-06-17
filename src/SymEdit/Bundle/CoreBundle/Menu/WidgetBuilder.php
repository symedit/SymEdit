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

class WidgetBuilder implements MenuBuilderInterface
{
    public function buildMenu(MenuInterface $menu, array $options)
    {
        $structure = $menu->getRootNode()->getChild('structure');
        $widgetExtras = ['is_granted' => 'ROLE_ADMIN_WIDGET'];

        $structure->addChild('Widgets', ['dropdown-header' => true, 'extras' => $widgetExtras]);
        $structure->addChild('New Widget', ['route' => 'admin_widget_choose', 'icon' => 'edit', 'extras' => $widgetExtras]);
        $structure->addChild('List Widgets', ['route' => 'admin_widget', 'icon' => 'tasks', 'extras' => $widgetExtras]);
    }
}
