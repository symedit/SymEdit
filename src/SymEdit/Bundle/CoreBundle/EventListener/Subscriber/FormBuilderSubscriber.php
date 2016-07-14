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

use SymEdit\Bundle\CoreBundle\Util\SymEditMailerInterface;
use SymEdit\Bundle\FormBuilderBundle\Event\Events;
use SymEdit\Bundle\FormBuilderBundle\Event\FormBuilderResultEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class FormBuilderSubscriber implements EventSubscriberInterface
{
    protected $mailer;

    public function __construct(SymEditMailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function onFormSuccess(FormBuilderResultEvent $event)
    {
        $result = $event->getResult();

        $this->mailer->sendAdmin('@SymEdit/Email/form-builder.html.twig', [
            'form_builder' => $event->getFormBuilder(),
            'pairs' => $result->getPairs(),
        ], [
            'replyTo' => $result->getReplyTo(),
        ]);
    }

    public static function getSubscribedEvents()
    {
        return [
            Events::FORM_SUCCESS => 'onFormSuccess',
        ];
    }
}
