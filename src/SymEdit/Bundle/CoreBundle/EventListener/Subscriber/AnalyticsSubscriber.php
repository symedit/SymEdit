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

use SymEdit\Bundle\AnalyticsBundle\Analytics\Tracker;
use SymEdit\Bundle\CoreBundle\Event\Events;
use SymEdit\Bundle\CoreBundle\Event\SubjectEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AnalyticsSubscriber implements EventSubscriberInterface
{
    protected $tracker;

    public function __construct(Tracker $tracker)
    {
        $this->tracker = $tracker;
    }

    public function onSubjectSet(SubjectEvent $event)
    {
        $subject = $event->getSubject();
        $this->tracker->track($subject);
    }

    public static function getSubscribedEvents()
    {
        return array(
            Events::SUBJECT_SET => 'onSubjectSet',
        );
    }
}
