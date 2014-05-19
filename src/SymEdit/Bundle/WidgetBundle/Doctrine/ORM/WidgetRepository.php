<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\WidgetBundle\Doctrine\ORM;

use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;
use SymEdit\Bundle\WidgetBundle\Widget\WidgetRegistry;

class WidgetRepository extends EntityRepository
{
    protected $registry;

    public function setRegistry(WidgetRegistry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * @return WidgetInterface
     */
    public function createNew($strategyName = null)
    {
        $class = $this->getClassName();
        $widget = new $class();

        if ($strategyName !== null) {
            $widget->setStrategyName($strategyName);
            $this->registry->init($widget);
        }

        return $widget;
    }
}
