<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\AnalyticsBundle\EventListener;

use SymEdit\Bundle\AnalyticsBundle\Analytics\Tracker;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\PostResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Delay the flushing / persisting of analytics entities until the
 * kernel terminate event to not delay the response. 
 */
class FlushVisitsSubscriber implements EventSubscriberInterface
{
    protected $tracker;

    public function __construct(Tracker $tracker)
    {
        $this->tracker = $tracker;
    }

    public function onKernelTerminate(PostResponseEvent $event)
    {
        $this->tracker->flush();
    }

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::TERMINATE => 'onKernelTerminate',
        );
    }
}