<?php

namespace SymEdit\Bundle\CoreBundle\Routing;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class RoutingConfiguration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('controllers');

        $rootNode
            ->useAttributeAsKey('name')
            ->prototype('array')
                ->children()
                    ->arrayNode('routes')->prototype('scalar')->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
