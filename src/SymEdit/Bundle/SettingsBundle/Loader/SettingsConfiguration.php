<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\SettingsBundle\Loader;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class SettingsConfiguration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('settings');

        $rootNode
            ->prototype('array')
                ->children()
                    ->scalarNode('label')->end()
                    ->arrayNode('settings')
                        ->children()
                            ->scalarNode('type')->defaultValue('text')->isRequired()->end()
                            ->scalarNode('default')->defaultNull()->end()
                            ->arrayNode('options')
                                ->prototype('array')
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}