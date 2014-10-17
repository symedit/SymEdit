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

class RouterLoaderCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $routerLoaderDefinition = $container->getDefinition('routing.loader');
        $routerLoaderDefinition->setClass('%symedit.routing.loader.class%');
        $routerLoaderDefinition->addMethodCall('setRouteManager', array(new Reference('symedit.routing.manager')));
        $routerLoaderDefinition->addMethodCall('setRouteStorage', array(new Reference('symedit.routing.storage')));
    }
}
