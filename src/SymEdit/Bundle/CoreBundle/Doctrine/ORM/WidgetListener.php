<?php

namespace Isometriks\Bundle\SymEditBundle\Doctrine\ORM;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Isometriks\Bundle\SymEditBundle\Doctrine\AbstractWidgetListener;

class WidgetListener extends AbstractWidgetListener
{
    public function getSubscribedEvents()
    {
        return array(
            Events::postLoad,
        );
    }

    public function postLoad(LifecycleEventArgs $args)
    {
        $this->loadWidget($args);
    }
}