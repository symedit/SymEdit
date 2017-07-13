<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Widget\Strategy;

use SymEdit\Bundle\CoreBundle\Model\PageInterface;
use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;
use SymEdit\Bundle\WidgetBundle\Widget\Strategy\WidgetStrategyInterface as BaseWidgetStrategyInterface;

/**
 * Allow a PageInterface to be passed into the widget execute if one exists.
 */
interface PageAwareWidgetStrategyInterface extends BaseWidgetStrategyInterface
{
    /**
     * Executes the strategy.
     *
     * @param WidgetInterface $widget The widget to be rendered
     * @param PageInterface   $page   $name If a page is currently active it will be passed
     */
    public function execute(WidgetInterface $widget, PageInterface $page = null);
}
