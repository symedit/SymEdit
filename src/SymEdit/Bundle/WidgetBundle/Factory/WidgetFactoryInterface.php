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

interface WidgetFactoryInterface extends FactoryInterface
{
    /**
     * @return WidgetInterface
     */
    public function createFromStrategy($strategyName = null, array $options = []);
}
