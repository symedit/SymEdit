<?php

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
