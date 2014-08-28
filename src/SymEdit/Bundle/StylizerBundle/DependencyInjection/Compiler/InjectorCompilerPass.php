<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\StylizerBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class InjectorCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $injectors = array();
        foreach ($container->findTaggedServiceIds('stylizer.injector') as $id => $attributes) {
            $definition = $container->getDefinition($id);
            $definition->addMethodCall('setFilterManager', array(new Reference('assetic.filter_manager')));
            $injectors[] = new Reference($id);
        }

        $injectorChainDefinition = $container->getDefinition('symedit_stylizer.injector');
        $injectorChainDefinition->replaceArgument(0, $injectors);
    }
}
