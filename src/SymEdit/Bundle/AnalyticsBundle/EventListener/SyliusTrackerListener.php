<?php

namespace SymEdit\Bundle\AnalyticsBundle\EventListener;

use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use SymEdit\Bundle\AnalyticsBundle\Analytics\Tracker;

class SyliusTrackerListener
{
    private $tracker;

    public function __construct(Tracker $tracker)
    {
        $this->tracker = $tracker;
    }

    public function track(ResourceControllerEvent $event)
    {
        $this->tracker->track($event->getSubject());
    }
}