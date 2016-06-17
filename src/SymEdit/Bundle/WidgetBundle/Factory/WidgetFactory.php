<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\WidgetBundle\Factory;

use Sylius\Component\Resource\Factory\FactoryInterface;
use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;
use SymEdit\Bundle\WidgetBundle\Widget\WidgetRegistry;

class WidgetFactory implements WidgetFactoryInterface
{
    protected $defaultFactory;
    protected $registry;

    public function __construct(FactoryInterface $defaultFactory, WidgetRegistry $registry)
    {
        $this->defaultFactory = $defaultFactory;
        $this->registry = $registry;
    }

    /**
     * @return WidgetInterface
     */
    public function createNew()
    {
        return $this->defaultFactory->createNew();
    }

    /**
     * Create a widget from a strategy name.
     *
     * @param type $strategyName
     * @param array $options
     * @return WidgetInterface
     */
    public function createFromStrategy($strategyName = null, array $options = [])
    {
        $widget = $this->createNew();

        if ($strategyName !== null) {
            $widget->setStrategyName($strategyName);
            $this->registry->init($widget, $options);
        }

        return $widget;
    }
}
