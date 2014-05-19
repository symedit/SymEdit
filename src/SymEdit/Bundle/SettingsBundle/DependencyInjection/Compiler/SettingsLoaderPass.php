<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\SettingsBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class SettingsLoaderPass implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        $themeLoaders = array();
        foreach ($container->findTaggedServiceIds('symedit_settings.settings_loader') as $id => $attributes) {
            $themeLoaders[] = new Reference($id);
        }

        $container->getDefinition('symedit_settings.loader_resolver')->replaceArgument(0, array_values($themeLoaders));
    }
}
