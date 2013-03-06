<?php

namespace Isometriks\Bundle\SettingsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * IsometriksSettings Configuration
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('isometriks_settings');
        
        $rootNode->children()
            ->arrayNode('twig')->addDefaultsIfNotSet()->children()
                ->booleanNode('global')->defaultFalse()->end()
                ->scalarNode('global_variable')->defaultValue('Settings')->end()
            ->end()
        ->end(); 

        return $treeBuilder;
    }
}
