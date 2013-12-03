<?php

namespace Isometriks\Bundle\SeoBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('isometriks_seo');

        $rootNode
            ->children()
                ->arrayNode('limit')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->integerNode('title')->defaultValue(65)->end()
                        ->integerNode('description')->defaultValue(155)->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
