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

use Sylius\Component\Resource\Factory\Factory;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Parameter;
use Symfony\Component\DependencyInjection\Reference;

class WidgetFactoryCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $defaultFactoryDefinition = new Definition(
            Factory::class,
            [
                new Parameter('symedit.model.widget.class'),
            ]
        );

        $widgetFactoryDefinition = new Definition(
            $container->getParameter('symedit.factory.widget.class'),
            [
                $defaultFactoryDefinition,
                new Reference('symedit_widget.widget.registry'),
            ]
        );

        $container->setDefinition('symedit.factory.widget', $widgetFactoryDefinition);
    }
}
