<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\SeoBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('symedit_seo');

        $rootNode
            ->children()
                ->arrayNode('limit')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->integerNode('title')->defaultValue(65)->end()
                        ->integerNode('description')->defaultValue(155)->end()
                    ->end()
                ->end()
                ->arrayNode('models')
                    ->prototype('array')
                        ->children()
                            ->arrayNode('title')
                                ->prototype('scalar')->end()
                            ->end()
                            ->arrayNode('description')
                                ->prototype('scalar')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
