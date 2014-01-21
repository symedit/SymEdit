<?php

namespace SymEdit\Bundle\MediaBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('symedit_media');

        $supportedDrivers = array('orm');

        $rootNode
            ->children()
                ->scalarNode('db_driver')
                    ->validate()
                        ->ifNotInArray($supportedDrivers)
                        ->thenInvalid('The driver %s is not supported. Choose one of '.json_encode($supportedDrivers))
                    ->end()
                    ->defaultValue('orm')
                    ->cannotBeOverwritten()
                ->end()
                ->scalarNode('model_manager_name')
                    ->defaultNull()
                ->end()
                ->scalarNode('web_root')
                    ->defaultValue('%kernel.root_dir%/../web')
                ->end()
                ->scalarNode('upload_dir')
                    ->defaultValue('img/uploads')
                ->end()
            ->end();

        return $treeBuilder;
    }
}
