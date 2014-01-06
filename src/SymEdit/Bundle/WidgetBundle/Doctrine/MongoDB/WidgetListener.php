<?php

namespace SymEdit\Bundle\WidgetBundle\Doctrine\MongoDB;

use Doctrine\ODM\MongoDB\Event\LifecycleEventArgs;
use Doctrine\ODM\MongoDB\Events;
use SymEdit\Bundle\WidgetBundle\Doctrine\AbstractWidgetListener;

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