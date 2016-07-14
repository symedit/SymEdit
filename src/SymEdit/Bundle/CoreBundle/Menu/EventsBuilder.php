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

class EventsBuilder implements MenuBuilderInterface
{
    public function buildMenu(MenuInterface $menu, array $options)
    {
        $content = $menu->getRootNode()->getChild('content');
        $eventExtras = ['is_granted' => 'ROLE_ADMIN_EVENT'];

        $content->addChild('Events', ['dropdown-header' => true, 'extras' => $eventExtras]);
        $content->addChild('View Events', ['route' => 'admin_event', 'icon' => 'list', 'extras' => $eventExtras]);
        $content->addChild('Add Event', ['route' => 'admin_event_create', 'icon' => 'plus', 'extras' => $eventExtras]);
    }
}
