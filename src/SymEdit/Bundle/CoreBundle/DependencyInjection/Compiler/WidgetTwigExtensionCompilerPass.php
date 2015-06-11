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

class WidgetTwigExtensionCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('symedit_widget.twig.widget_extension')) {
            return;
        }

        $definition = $container->getDefinition('symedit_widget.twig.widget_extension');
        $definition->setClass('SymEdit\Bridge\Widget\Twig\Extension\WidgetExtension');
    }
}
