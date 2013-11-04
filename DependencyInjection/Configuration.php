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

        $supportedDrivers = array('orm', 'mongodb');
        
        $rootNode
            ->children()
                ->scalarNode('db_driver')
                    ->validate()
                        ->ifNotInArray($supportedDrivers)
                        ->thenInvalid('The driver %s is not supported. Choose one of '.json_encode($supportedDrivers))
                    ->end()
                    ->info('Database driver to use, one of: '.json_encode($supportedDrivers))
                    ->defaultValue('orm')
                    ->cannotBeOverwritten()
                ->end()
                ->scalarNode('model_manager_name')->defaultNull()->end()
                ->scalarNode('admin_dir')->defaultValue('sym-admin')->end()
                ->arrayNode('extensions')
                    ->info('Extensions to add to extensions menu in admin menu')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('route')->end()
                            ->scalarNode('label')->end()
                            ->scalarNode('role')->defaultValue('ROLE_ADMIN')->end()
                            ->scalarNode('icon')->defaultNull()->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('profile')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('admin_type')->defaultValue('symedit_admin_profile')->end()
                        ->scalarNode('user_type')->defaultValue('symedit_user_profile')->end()
                    ->end()
                ->end()
                ->arrayNode('email')
                    ->info('Default email address from which to send')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('sender')->defaultValue('email@example.com')->end()
                    ->end()
                ->end()
                ->arrayNode('fragment')
                    ->info('Fragment stategy to use')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('strategy')->defaultValue('inline')->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
