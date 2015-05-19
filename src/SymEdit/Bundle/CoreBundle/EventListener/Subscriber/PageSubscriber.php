<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\EventListener\Subscriber;

use SymEdit\Bundle\CoreBundle\Model\PageInterface;
use Sylius\Component\Resource\Event\ResourceEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PageSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            'symedit.page.pre_delete' => 'pagePreDelete',
        );
    }

    public function pagePreDelete(ResourceEvent $event)
    {
        /* @var $page PageInterface */
        $page = $event->getSubject();

        /*
         * Don't allow deletion of homepage / root
         */
        if ($page->getHomepage() || $page->getRoot()) {
            $event->stop('symedit.page.root_or_home');
        }
    }
}
