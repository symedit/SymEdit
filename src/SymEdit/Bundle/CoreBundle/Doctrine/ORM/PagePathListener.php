<?php

namespace SymEdit\Bundle\CoreBundle\Doctrine\ORM;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use SymEdit\Bundle\CoreBundle\Doctrine\AbstractPagePathListener;

class PagePathListener extends AbstractPagePathListener
{
    public function getSubscribedEvents() 
    {
        return array(
            Events::postPersist,
            Events::postUpdate,
        );
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $this->updateRoutes($args);
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->updateRoutes($args);
    }
}