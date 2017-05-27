<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\EventsBundle\DependencyInjection;

use Sylius\Component\Resource\Factory\Factory;
use SymEdit\Bundle\EventsBundle\Controller\EventController;
use SymEdit\Bundle\EventsBundle\Form\Type\EventType;
use SymEdit\Bundle\EventsBundle\Model\Event;
use SymEdit\Bundle\EventsBundle\Model\EventInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
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
        $rootNode = $treeBuilder->root('symedit_events');

        $rootNode
            ->children()
                ->scalarNode('driver')->cannotBeEmpty()->defaultValue('doctrine/orm')->end()
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
                        ->arrayNode('event')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->arrayNode('classes')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('model')->defaultValue(Event::class)->end()
                                        ->scalarNode('interface')->defaultValue(EventInterface::class)->end()
                                        ->scalarNode('controller')->defaultValue(EventController::class)->end()
                                        ->scalarNode('respository')->end()
                                        ->scalarNode('factory')->defaultValue(Factory::class)->end()
                                        ->scalarNode('form')->defaultValue(EventType::class)->cannotBeEmpty()->end()
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
