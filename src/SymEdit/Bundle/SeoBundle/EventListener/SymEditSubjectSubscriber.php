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
    protected $preferences;

    public function __construct(SeoManagerInterface $seoManager, array $preferences = [])
    {
        $this->seoManager = $seoManager;
        $this->preferences = $preferences;
    }

    public function onSymEditSubjectSet(SubjectEvent $event)
    {
        $subject = $event->getSubject();

        if ($this->hasModel($subject)) {
            $this->seoManager->setSubject($subject);
        }
    }

    protected function hasModel($subject)
    {
        foreach ($this->preferences as $preference) {
            $model = $preference->getModel();

            if ($subject instanceof $model) {
                return true;
            }
        }

        return false;
    }

    public static function getSubscribedEvents()
    {
        $events = [];

        if (class_exists('SymEdit\Bundle\CoreBundle\Event\Events')) {
            $events[Events::SUBJECT_SET] = 'onSymEditSubjectSet';
        }

        return $events;
    }
}
