<?php

namespace SymEdit\Bundle\WidgetBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class WidgetStrategyCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        $tags = $container->findTaggedServiceIds('symedit_widget.widget_strategy');
        $strategies = array();

        foreach ($tags as $id => $tags) {
            foreach ($tags as $attr) {
                if (!isset($attr['alias'])) {
                    throw new \InvalidArgumentException(sprintf('Missing "alias" for widget for service id "%s"', $id));
                }

                $strategies[$attr['alias']] = $id;
            }
        }

        $container->setParameter('symedit_widget.widget.strategies', $strategies);
    }
}