<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\SitemapBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('symedit_sitemap');

        $allowedFreq = [
            'always', 'hourly', 'daily', 'weekly', 'monthly',
            'yearly', 'never',
        ];

        $rootNode
            ->children()
                ->arrayNode('models')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->performNoDeepMerging()
                        ->children()
                            ->scalarNode('repository')->defaultNull()->end()
                            ->scalarNode('method')->defaultValue('findAll')->end()
                            ->arrayNode('route')
                                ->children()
                                    ->scalarNode('path')->end()
                                    ->arrayNode('params')->prototype('scalar')->end()->end()
                                    ->booleanNode('ignore')->defaultFalse()->end()
                                ->end()
                                ->beforeNormalization()
                                    ->ifTrue(function ($v) {
                                        return !is_array($v);
                                    })
                                    ->then(function ($v) {
                                        return [
                                            'path' => $v,
                                            'params' => [],
                                            'ignore' => false,
                                        ];
                                    })
                                ->end()
                            ->end()
                            ->arrayNode('callbacks')
                                ->prototype('scalar')->end()
                            ->end()
                            ->scalarNode('changefreq')
                                ->validate()
                                    ->ifNotInArray($allowedFreq)
                                    ->thenInvalid('Change frequency not supported, choose one of: '.json_encode($allowedFreq))
                                ->end()
                                ->defaultValue('weekly')
                            ->end()
                            ->scalarNode('lastmod')->defaultNull()->end()
                            ->scalarNode('priority')->defaultValue('0.5')->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
