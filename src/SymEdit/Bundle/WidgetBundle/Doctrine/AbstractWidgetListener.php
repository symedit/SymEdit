<?php

namespace SymEdit\Bundle\CoreBundle\Doctrine;

use Doctrine\Common\EventSubscriber;
use SymEdit\Bundle\CoreBundle\Model\WidgetInterface;
use SymEdit\Bundle\CoreBundle\Widget\WidgetRegistry;

abstract class AbstractWidgetListener implements EventSubscriber
{
    protected $registry;

    public function __construct(WidgetRegistry $registry)
    {
        $this->registry = $registry;
    }

    protected function loadWidget($args)
    {
        $entity = $args->getEntity();

        if ($entity instanceof WidgetInterface) {
            $this->registry->injectStrategy($entity);
        }
    }
}