<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
                ->validate()
                    ->always()
                    ->then(function ($v) {
                        $v['routes'] = array_unique($v['routes']);

                        return $v;
                    })
                ->end()
                ->children()
                    ->arrayNode('routes')->prototype('scalar')->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
