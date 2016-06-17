<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\ThemeBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class TwigLoaderPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $loaderDefinition = $container->getDefinition('twig.loader.filesystem');
        $loaderDefinition->setClass('%symedit_theme.twig.loader.filesystem%');
        $loaderDefinition->addMethodCall('setThemePaths', [
            new Reference('symedit_theme.theme'),
            $container->getParameter('symedit_theme.namespace_overrides'),
        ]);
    }
}
