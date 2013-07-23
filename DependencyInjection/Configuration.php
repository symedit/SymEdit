<?php

namespace Isometriks\Bundle\SymEditBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('isometriks_symedit');

        $rootNode
            ->children()
                ->scalarNode('host_bundle')->end()
                ->scalarNode('admin_dir')->defaultValue('sym-admin')->end()
                ->arrayNode('extensions')
                    ->prototype('array')
                    ->children()
                        ->scalarNode('route')->end()
                        ->scalarNode('label')->end()
                        ->scalarNode('role')->defaultValue('ROLE_ADMIN')->end()
                        ->scalarNode('icon')->defaultNull()->end()
                    ->end()
                ->end()
            ->end(); 

        return $treeBuilder;
    }
}
