<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\WidgetBundle\EventListener;

use SymEdit\Bundle\WidgetBundle\Event\Events;
use SymEdit\Bundle\WidgetBundle\Event\WidgetEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class WidgetCacheSubscriber implements EventSubscriberInterface
{
    public function setStrategyCache(WidgetEvent $event)
    {
        $widget = $event->getWidget();
        $cacheOptions = $event->getStrategy()->getCacheOptions($widget);

        // Set options on response
        $event->getResponse()->setCache($cacheOptions);
    }

    public static function getSubscribedEvents()
    {
        return [
            Events::WIDGET_PRE_RENDER => [
                ['setStrategyCache', 128],
            ]
        ];
    }
}
