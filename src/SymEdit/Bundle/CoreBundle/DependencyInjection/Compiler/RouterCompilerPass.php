<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class RouterCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $routerLoaderDefinition = $container->getDefinition('router.default');
        $routerLoaderDefinition->setClass('%symedit.routing.router.class%');
        $routerLoaderDefinition->addMethodCall('setRouteManager', [new Reference('symedit.routing.manager')]);
        $routerLoaderDefinition->addMethodCall('setRouteStorage', [new Reference('symedit.routing.storage')]);
        $container->setAlias('symfony_router', 'router.default');
    }
}
