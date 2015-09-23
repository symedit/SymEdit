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

use SymEdit\Bundle\ThemeBundle\DependencyInjection\BundleTemplateLoaderDefinition;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class TemplateResourcesPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $bundles = $container->getParameter('symedit_theme.templates.bundles');

        foreach ($bundles as $bundle) {
            $container->setDefinition(
                'symedit_theme.template.loader.bundle.'.$bundle,
                new BundleTemplateLoaderDefinition($bundle)
            );
        }
    }
}
