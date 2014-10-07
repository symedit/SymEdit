<?php

namespace SymEdit\Bridge\Widget\Menu;

use SymEdit\Bundle\MenuBundle\Model\MenuBuilderInterface;
use SymEdit\Bundle\MenuBundle\Model\MenuInterface;

class Builder implements MenuBuilderInterface
{
    public function buildMenu(MenuInterface $menu, array $options)
    {
        $structure = $menu->getRootNode()->getChild('structure');
        $widgetExtras = array('is_granted' => 'ROLE_ADMIN_WIDGET');
        
        $structure->addChild('Widgets', array('dropdown-header' => true, 'extras' => $widgetExtras));
        $structure->addChild('New Widget', array('route' => 'admin_widget_choose', 'icon' => 'edit', 'extras' => $widgetExtras));
        $structure->addChild('List Widgets', array('route' => 'admin_widget', 'icon' => 'tasks', 'extras' => $widgetExtras));
    }
}
