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

use SymEdit\Bundle\CoreBundle\Event\Events;
use SymEdit\Bundle\CoreBundle\Event\FormEvent;
use SymEdit\Bundle\CoreBundle\Util\SymEditMailerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ContactSubscriber implements EventSubscriberInterface
{
    protected $mailer;

    public function __construct(SymEditMailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public static function getSubscribedEvents()
    {
        return [
            Events::CONTACT_SUBMIT_VALID => 'sendAdminEmail',
        ];
    }

    public function sendAdminEmail(FormEvent $event)
    {
        $data = $event->getForm()->getData();

        // Set ReplyTo
        $options = empty($data['email']) ? [] : [
            'replyTo' => $data['email'],
        ];

        $this->mailer->sendAdmin('@SymEdit/Contact/contact.html.twig', [
            'Form' => $data,
        ], $options);
    }
}
