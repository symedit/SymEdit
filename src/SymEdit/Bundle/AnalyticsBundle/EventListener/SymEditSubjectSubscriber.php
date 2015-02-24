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
use SymEdit\Bundle\CoreBundle\Event\Events;
use SymEdit\Bundle\CoreBundle\Event\SubjectEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * @TODO: Move to corebundle, this doesn't really need to be here.
 */
class SymEditSubjectSubscriber implements EventSubscriberInterface
{
    protected $tracker;

    public function __construct(Tracker $tracker)
    {
        $this->tracker = $tracker;
    }

    public function onSymEditSubjectSet(SubjectEvent $event)
    {
        $subject = $event->getSubject();
        $this->tracker->track($subject);
    }

    public static function getSubscribedEvents()
    {
        if (class_exists('SymEdit\Bundle\CoreBundle\Event\Events')) {
            $events[Events::SUBJECT_SET] = 'onSymEditSubjectSet';
        }

        return $events;
    }
}
