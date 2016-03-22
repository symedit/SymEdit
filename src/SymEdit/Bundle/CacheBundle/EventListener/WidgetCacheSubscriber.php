<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CacheBundle\EventListener;

use FOS\HttpCacheBundle\Handler\TagHandler;
use Sylius\Bundle\SettingsBundle\Manager\SettingsManager;
use SymEdit\Bundle\CacheBundle\Decision\CacheDecisionManager;
use SymEdit\Bundle\WidgetBundle\Event\Events;
use SymEdit\Bundle\WidgetBundle\Event\WidgetEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class WidgetCacheSubscriber implements EventSubscriberInterface
{
    private $manager;
    private $settings;

    public function __construct(CacheDecisionManager $manager, SettingsManager $settings)
    {
        $this->manager = $manager;
        $this->settings = $settings;
    }

    /**
     * Use decision manager to decide if widget should be cached at all.
     *
     * @param WidgetEvent $event
     */
    public function decideWidgetCache(WidgetEvent $event)
    {
        // Stop Event Propogation to prevent cache being set
        if (!$this->manager->decide($event->getWidget())) {
            $event->stopPropagation();
        }
    }

    /**
     * Sets the TTL on widget cache after the other cache options have been set,
     * this allows us to make sure widgets refresh every so often regardless.
     *
     * @param WidgetEvent $event
     */
    public function setSharedCache(WidgetEvent $event)
    {
        // Not cacheable, don't add anything
        if (!$event->getResponse()->isCacheable()) {
            return;
        }

        $advancedSettings = $this->settings->loadSettings('advanced');
        $ttl = $advancedSettings->get('widget_max_age');

        // Set max lifetime for widgets
        $event->getResponse()->setSharedMaxAge($ttl);
    }

    public static function getSubscribedEvents()
    {
        return array(
            Events::WIDGET_PRE_RENDER => array(
                array('decideWidgetCache', 256),
                array('setSharedCache', 64),
            ),
        );
    }
}
