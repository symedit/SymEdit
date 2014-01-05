<?php

namespace Isometriks\Bundle\SymEditBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class WidgetStrategyCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $tags = $container->findTaggedServiceIds('symedit.widget_strategy'); 
        $strategies = array();
        
        foreach ($tags as $id => $tags) {
            foreach ($tags as $attr) {
                if (!isset($attr['alias'])) {
                    throw new \InvalidArgumentException(sprintf('Missing "alias" for widget for service id "%s"', $id));
                }
                
                $strategies[$attr['alias']] = $id;
            }
        }
        
        $container->setParameter('isometriks_symedit.widget.strategies', $strategies); 
    }
}