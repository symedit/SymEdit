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

use SymEdit\Bundle\CoreBundle\Mailer\MailerInterface;
use SymEdit\Bundle\FormBuilderBundle\Event\Events;
use SymEdit\Bundle\FormBuilderBundle\Event\FormBuilderResultEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class FormBuilderSubscriber implements EventSubscriberInterface
{
    protected $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function onFormSuccess(FormBuilderResultEvent $event)
    {
        $result = $event->getResult();

        $this->mailer->send('form_builder_result', [
            'form_builder' => $event->getFormBuilder(),
            'result' => $result,
        ]);
    }

    public static function getSubscribedEvents()
    {
        return [
            Events::FORM_SUCCESS => 'onFormSuccess',
        ];
    }
}
