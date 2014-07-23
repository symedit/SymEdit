<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CacheBundle\Sylius\Pointcut;

use JMS\AopBundle\Aop\PointcutInterface;

class SyliusResourcePointcut implements PointcutInterface
{
    const CONTROLLER = 'Sylius\Bundle\ResourceBundle\Controller\ResourceController';

    public function matchesClass(\ReflectionClass $class)
    {
        return $class->isSubclassOf(self::CONTROLLER) || $class === self::CONTROLLER;
    }

    public function matchesMethod(\ReflectionMethod $method)
    {
        return $method->getName() === 'showAction';
    }
}
