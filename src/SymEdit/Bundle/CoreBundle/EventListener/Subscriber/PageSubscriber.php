<?php

namespace SymEdit\Bundle\CoreBundle\EventListener\Subscriber;

use SymEdit\Bundle\CoreBundle\Event\Events;
use SymEdit\Bundle\CoreBundle\Model\PageInterface;
use Sylius\Bundle\ResourceBundle\Event\ResourceEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\Session;

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
            Events::PAGE_CREATE => 'pageCreate',
            Events::PAGE_UPDATE => 'pageUpdate',
            Events::PAGE_PRE_DELETE => 'pagePreDelete',
        );
    }

    public function pageCreate(ResourceEvent $event)
    {
        $this->session->getFlashBag()->add('notice', 'admin.page.flash.created');
    }

    public function pageUpdate(ResourceEvent $event)
    {
        $this->session->getFlashBag()->add('notice', 'admin.page.flash.updated');
    }

    public function pagePreDelete(ResourceEvent $event)
    {
        /* @var $page PageInterface */
        $page = $event->getSubject();

        /**
         * Don't allow deletion of homepage / root
         */
        if ($page->getHomepage() || $page->getRoot()) {
            $event->stop('Cannot delete');
        }
    }
}