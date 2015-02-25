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
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;

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

    public function onKernelController(FilterControllerEvent $event)
    {
        if ($event->getRequestType() !== HttpKernelInterface::MASTER_REQUEST) {
            return;
        }

        $request = $event->getRequest();

        // Check if controller index
        if (!$request->attributes->get('_controller_index', false)) {
            return;
        }

        // Get page from Request
        $page = $request->attributes->get('_page');

        // Track page
        $this->tracker->track($page);
    }

    public static function getSubscribedEvents()
    {
        return array(
            Events::SUBJECT_SET => 'onSubjectSet',
            KernelEvents::CONTROLLER => 'onKernelController',
        );
    }
}
