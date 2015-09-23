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

/**
 * Code reused from Symfony2 AddSecurityVotersPass.
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
class TemplateLoaderPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $loaders = new \SplPriorityQueue();
        foreach ($container->findTaggedServiceIds('symedit_theme.template_loader') as $id => $attributes) {
            $priority = isset($attributes[0]['priority']) ? $attributes[0]['priority'] : 0;
            $loaders->insert(new Reference($id), $priority);
        }

        $loaders = iterator_to_array($loaders);
        ksort($loaders);

        $container->getDefinition('symedit_theme.template.loader')->replaceArgument(0, array_values($loaders));
    }
}
