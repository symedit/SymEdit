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

use Sylius\Component\Resource\Factory\Factory;
use SymEdit\Bundle\ResourceBundle\Controller\ResourceController;
use SymEdit\Bundle\WidgetBundle\Controller\WidgetController;
use SymEdit\Bundle\WidgetBundle\Factory\WidgetFactory;
use SymEdit\Bundle\WidgetBundle\Form\Type\WidgetAreaType;
use SymEdit\Bundle\WidgetBundle\Form\Type\WidgetType;
use SymEdit\Bundle\WidgetBundle\Model\Widget;
use SymEdit\Bundle\WidgetBundle\Model\WidgetArea;
use SymEdit\Bundle\WidgetBundle\Model\WidgetAreaInterface;
use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
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
                ->arrayNode('renderer')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('widget')->defaultValue('symedit_widget.renderer.widget')->end()
                        ->scalarNode('area')->defaultValue('symedit_widget.renderer.area')->end()
                    ->end()
                ->end()
            ->end();

        $this->addResourcesSection($rootNode);

        return $treeBuilder;
    }

    /**
     * Add classes config to be processed by the Sylius Resource Bundle.
     *
     * @param ArrayNodeDefinition $node
     */
    private function addResourcesSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('resources')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('widget')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->arrayNode('classes')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('model')->defaultValue(Widget::class)->end()
                                        ->scalarNode('interface')->defaultValue(WidgetInterface::class)->end()
                                        ->scalarNode('controller')->defaultValue(WidgetController::class)->end()
                                        ->scalarNode('respository')->end()
                                        ->scalarNode('factory')->defaultValue(WidgetFactory::class)->end()
                                        ->scalarNode('form')->defaultValue(WidgetType::class)->cannotBeEmpty()->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()

                        ->arrayNode('widget_area')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->arrayNode('classes')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('model')->defaultValue(WidgetArea::class)->end()
                                        ->scalarNode('interface')->defaultValue(WidgetAreaInterface::class)->end()
                                        ->scalarNode('controller')->defaultValue(ResourceController::class)->end()
                                        ->scalarNode('repository')->end()
                                        ->scalarNode('factory')->defaultValue(Factory::class)->end()
                                        ->scalarNode('form')->defaultValue(WidgetAreaType::class)->cannotBeEmpty()->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
