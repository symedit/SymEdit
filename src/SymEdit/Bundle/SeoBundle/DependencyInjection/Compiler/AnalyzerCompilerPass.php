<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\SeoBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class AnalyzerCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $tags = $container->findTaggedServiceIds('symedit_seo.analyzer');
        $analyzers = [];

        foreach ($tags as $id => $tags) {
            $analyzers[] = new Reference($id);
        }

        $analyzerDefinition = $container->getDefinition('symedit_seo.analyzer');
        $analyzerDefinition->replaceArgument(0, $analyzers);
    }
}
