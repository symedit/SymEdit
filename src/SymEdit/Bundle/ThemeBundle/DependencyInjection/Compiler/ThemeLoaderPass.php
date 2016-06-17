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

class ThemeLoaderPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $themeLoaders = [];
        foreach ($container->findTaggedServiceIds('symedit_theme.theme_loader') as $id => $attributes) {
            $themeLoaders[] = new Reference($id);
        }

        $container->getDefinition('symedit_theme.theme.loader_resolver')->replaceArgument(0, array_values($themeLoaders));
    }
}
