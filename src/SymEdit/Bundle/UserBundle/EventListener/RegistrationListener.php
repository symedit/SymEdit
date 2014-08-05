<?php

namespace SymEdit\Bundle\UserBundle\EventListener;

use FOS\UserBundle\Event\UserEvent;
use SymEdit\Bundle\CoreBundle\Util\SymEditMailer;

class RegistrationListener
{
    protected $mailer;
    protected $template;

    public function __construct(SymEditMailer $mailer, $template)
    {
        $this->mailer = $mailer;
        $this->template = $template;
    }

    public function sendNotification(UserEvent $event)
    {
        $this->mailer->sendAdmin($this->template, array(
            'user' => $event->getUser(),
        ));
    }
}
