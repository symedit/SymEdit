<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\ThemeBundle\Layout;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class LayoutConfiguration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('layout');

        $rootNode
            ->children()
                ->scalarNode('title')->defaultNull()->end()
                ->scalarNode('description')->defaultNull()->end()
                ->arrayNode('layout')
                    ->prototype('scalar')->defaultNull()->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
