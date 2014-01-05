<?php

namespace SymEdit\Bundle\StylizerBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class InjectorCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $definitions = array_keys($container->findTaggedServiceIds('stylizer.injector')); 
        $container->setParameter('symedit_stylizer.injectors', $definitions); 
    }
}