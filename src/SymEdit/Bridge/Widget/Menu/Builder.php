<?php

namespace SymEdit\Bridge\Widget\Menu;

use SymEdit\Bundle\MenuBundle\Model\MenuBuilderInterface;
use SymEdit\Bundle\MenuBundle\Model\MenuInterface;

class Builder implements MenuBuilderInterface
{
    public function buildMenu(MenuInterface $menu, array $options)
    {
        $structure = $menu->getRootNode()->getChild('structure');

        $structure->addChild('Widgets', array('dropdown-header' => true));
        $structure->addChild('New Widget', array('route' => 'admin_widget_choose', 'icon' => 'edit'));
        $structure->addChild('List Widgets', array('route' => 'admin_widget', 'icon' => 'tasks'));
    }
}
