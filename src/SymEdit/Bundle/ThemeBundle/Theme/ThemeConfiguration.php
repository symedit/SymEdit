<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\ThemeBundle\Theme;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class ThemeConfiguration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('theme');

        $rootNode
            ->children()
                ->scalarNode('name')->end()
                ->scalarNode('parent')->defaultNull()->end()
                ->scalarNode('title')->end()
                ->scalarNode('description')->end()
                ->append($this->addAssetNode('stylesheets'))
                ->append($this->addAssetNode('javascripts'))
            ->end()
        ;

        return $treeBuilder;
    }

    protected function addAssetNode($name)
    {
        $builder = new TreeBuilder();
        $node = $builder->root($name);

        $node
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('filters')
                    ->prototype('scalar')->end()
                ->end()
                ->arrayNode('inputs')
                    ->prototype('scalar')->end()
                ->end()
                ->arrayNode('options')
                    ->prototype('scalar')->end()
                ->end()
            ->end()
        ;

        return $node;
    }
}
