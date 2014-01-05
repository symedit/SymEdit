<?php

namespace Isometriks\Bundle\SymEditBundle\Doctrine\ORM;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Isometriks\Bundle\SymEditBundle\Doctrine\AbstractPagePathListener;

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