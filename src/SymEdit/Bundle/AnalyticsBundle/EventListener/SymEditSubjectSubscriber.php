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
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;

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

        if (is_object($subject) && !$subject instanceof \Traversable) {
            $this->tracker->track($subject);
        }
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        if ($event->getRequestType() !== HttpKernelInterface::MASTER_REQUEST) {
            return;
        }

        $request = $event->getRequest();
        $default = $request->get('_default_route', false);
        $symedit = $request->get('_symedit', array());
        $nonController = !isset($symedit['page_controller']);
        $page = $request->get('_page', null);

        if (($page !== null && $page->getId() !== null) && ($default || $nonController)) {
            $this->tracker->track($page);
        }
    }

    public static function getSubscribedEvents()
    {
        $events = array(
            KernelEvents::CONTROLLER => 'onKernelController',
        );

        if (class_exists('SymEdit\Bundle\CoreBundle\Event\Events')) {
            $events[Events::SUBJECT_SET] = 'onSymEditSubjectSet';
        }

        return $events;
    }
}
