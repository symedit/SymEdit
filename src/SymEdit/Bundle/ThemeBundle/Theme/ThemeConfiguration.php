<?php

namespace SymEdit\Bundle\ThemeBundle\Theme;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class ThemeConfiguration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('theme');

        $rootNode
            ->children()
                ->scalarNode('name')->end()
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