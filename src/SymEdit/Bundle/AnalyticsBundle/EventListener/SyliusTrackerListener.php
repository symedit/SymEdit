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
