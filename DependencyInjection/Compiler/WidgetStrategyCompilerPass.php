<?php

namespace Isometriks\Bundle\SymEditBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class WidgetStrategyCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $definitions = array_keys($container->findTaggedServiceIds('symedit.widget_strategy')); 
        $container->setParameter('isometriks_symedit.widget.strategies', $definitions); 
    }
}