<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\SeoBundle\EventListener;

use SymEdit\Bundle\CoreBundle\Event\Events;
use SymEdit\Bundle\CoreBundle\Event\SubjectEvent;
use SymEdit\Bundle\SeoBundle\Model\SeoManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;


class SymEditSubjectSubscriber implements EventSubscriberInterface
{
    protected $seoManager;

    public function __construct(SeoManagerInterface $seoManager)
    {
        $this->seoManager = $seoManager;
    }

    public function onSymEditSubjectSet(SubjectEvent $event)
    {
        $subject = $event->getSubject();

        if (is_object($subject) && !$subject instanceof \Traversable) {
            $this->seoManager->setSubject($subject);
        }
    }

    public static function getSubscribedEvents()
    {
        $events = array();

        if (class_exists('SymEdit\Bundle\CoreBundle\Event\Events')) {
            $events[Events::SUBJECT_SET] = 'onSymEditSubjectSet';
        }

        return $events;
    }
}