<?php

namespace Isometriks\Bundle\SymEditBundle\EventListener\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Isometriks\Bundle\SymEditBundle\Event\Events;
use Symfony\Component\HttpFoundation\Session\Session;
use Sylius\Bundle\ResourceBundle\Event\ResourceEvent;

class PageSubscriber implements EventSubscriberInterface
{
    protected $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public static function getSubscribedEvents()
    {
        return array(
            Events::PAGE_CREATED => 'pageCreated',
            Events::PAGE_UPDATED => 'pageUpdated',
        );
    }

    public function pageCreated(ResourceEvent $event)
    {
        $this->session->getFlashBag()->add('notice', 'admin.page.flash.created');
    }

    public function pageUpdated(ResourceEvent $event)
    {
        $this->session->getFlashBag()->add('notice', 'admin.page.flash.updated');
    }
}