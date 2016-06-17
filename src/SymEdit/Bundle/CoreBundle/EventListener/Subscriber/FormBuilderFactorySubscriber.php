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

use SymEdit\Bundle\FormBuilderBundle\Event\Events;
use SymEdit\Bundle\FormBuilderBundle\Event\FormBuilderFactoryEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class FormBuilderFactorySubscriber implements EventSubscriberInterface
{
    public function onFormBuild(FormBuilderFactoryEvent $event)
    {
        $event->mergeOptions([
            'timed_spam' => true,
            'honeypot' => true,
        ]);
    }

    public static function getSubscribedEvents()
    {
        return [
            Events::FORM_BUILD => 'onFormBuild',
        ];
    }
}
