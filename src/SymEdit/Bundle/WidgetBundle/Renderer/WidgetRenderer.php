<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\WidgetBundle\Renderer;

use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;
use SymEdit\Bundle\WidgetBundle\Widget\WidgetRegistry;

class WidgetRenderer implements WidgetRendererInterface
{
    protected $registry;

    public function __construct(WidgetRegistry $registry)
    {
        $this->registry = $registry;
    }

    public function render(WidgetInterface $widget)
    {
        return $this->getStrategy($widget)->execute($widget);
    }

    protected function getStrategy(WidgetInterface $widget)
    {
        return $this->registry->getStrategy($widget->getStrategyName());
    }
}
