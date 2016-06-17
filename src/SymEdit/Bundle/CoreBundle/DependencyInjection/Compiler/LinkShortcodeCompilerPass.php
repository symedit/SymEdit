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
use Symfony\Component\DependencyInjection\Reference;

/**
 * Find Link generators and replace argument.
 */
class LinkShortcodeCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $links = [];

        foreach ($container->findTaggedServiceIds('symedit.link') as $id => $tags) {
            $links[] = new Reference($id);
        }

        $container->getDefinition('symedit.shortcode.link')->replaceArgument(0, $links);
    }
}
