<?php

namespace Isometriks\Bundle\SymEditBundle\Doctrine\MongoDB;

use Doctrine\ODM\MongoDB\Event\LifecycleEventArgs;
use Doctrine\ODM\MongoDB\Events;
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