<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\EventsBundle\EventListener;

use SymEdit\Bundle\CoreBundle\Event\Events;
use SymEdit\Bundle\CoreBundle\Event\MenuEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

class MenuSubscriber implements EventSubscriberInterface
{
    protected $context;

    public function __construct(SecurityContextInterface $context)
    {
        $this->context = $context;
    }

    public static function getSubscribedEvents()
    {
        return array(
            Events::MENU_VIEW => 'viewMenu',
        );
    }

    public function viewMenu(MenuEvent $event)
    {
        // Only use main admin menu
        if ($event->getMenuName() !== 'symedit_admin') {
            return;
        }

        $rootNode = $event->getRootNode();

        if (!$rootNode->getChild('content')) {
            return;
        }

        $content = $rootNode->getChild('content');

        /**
         * Events
         */
        if ($this->context->isGranted('ROLE_ADMIN_EVENT')) {
            $content->addChild('Events', array('dropdown-header' => true));
            $content->addChild('View Events', array('route' => 'admin_event', 'icon' => 'list'));
            $content->addChild('Add Event', array('route' => 'admin_event_create', 'icon' => 'plus'));
        }
    }
}
