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

class LoaderCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $loaders = [];
        foreach ($container->findTaggedServiceIds('stylizer.loader') as $id => $attributes) {
            $loaders[] = new Reference($id);
        }

        $loadChainDefinition = $container->getDefinition('symedit_stylizer.loader.chain');
        $loadChainDefinition->replaceArgument(0, $loaders);
    }
}
