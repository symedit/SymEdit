<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\WidgetBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class WidgetStrategyCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $tags = $container->findTaggedServiceIds('symedit_widget.widget_strategy');
        $strategies = [];

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
