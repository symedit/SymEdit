<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\MailChimpBundle\EventListener;

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
        $site = $rootNode->getChild('Site');

        /**
         * No content, might not have permissions
         */
        if ($site === null) {
            return;
        }

        /*
        $site->addChild('MailChimp', array(
            'icon' => 'envelope',
            'route' => 'symedit_mailchimp_dashboard',
        ));
         */
    }
}
