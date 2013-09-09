<?php

namespace Isometriks\Bundle\SymEditBundle\Doctrine;

use Doctrine\Common\EventSubscriber;
use Isometriks\Bundle\SymEditBundle\Model\WidgetInterface;
use Isometriks\Bundle\SymEditBundle\Widget\WidgetRegistry;

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