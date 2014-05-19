<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\WidgetBundle\Doctrine;

use Doctrine\Common\EventSubscriber;
use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;
use SymEdit\Bundle\WidgetBundle\Widget\WidgetRegistry;

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
