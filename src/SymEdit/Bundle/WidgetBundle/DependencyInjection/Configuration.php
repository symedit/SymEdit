<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\WidgetBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
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
        $rootNode = $treeBuilder->root('symedit_widget');

        $rootNode
            ->children()
                ->scalarNode('driver')->defaultValue('doctrine/orm')->end()
                ->scalarNode('model_manager_name')->defaultNull()->end()
                ->arrayNode('fragment')
                    ->info('Fragment stategy to use')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('strategy')->defaultValue('inline')->end()
                    ->end()
                ->end()
            ->end();

        $this->addClassesSection($rootNode);

        return $treeBuilder;
    }

    /**
     * Add classes config to be processed by the Sylius Resource Bundle
     *
     * @param ArrayNodeDefinition $node
     */
    private function addClassesSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('classes')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('widget')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('model')->defaultValue('SymEdit\Bundle\WidgetBundle\Model\Widget')->end()
                                ->scalarNode('controller')->defaultValue('SymEdit\Bundle\WidgetBundle\Controller\WidgetController')->end()
                                ->scalarNode('respository')->end()
                                ->scalarNode('form')->defaultValue('SymEdit\Bundle\WidgetBundle\Form\Type\WidgetType')->end()
                            ->end()
                        ->end()
                        ->arrayNode('widget_area')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('model')->defaultValue('SymEdit\Bundle\WidgetBundle\Model\WidgetArea')->end()
                                ->scalarNode('repository')->end()
                                ->scalarNode('form')->defaultValue('SymEdit\Bundle\WidgetBundle\Form\Type\WidgetAreaType')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}
