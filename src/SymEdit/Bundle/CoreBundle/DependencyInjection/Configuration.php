<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\DependencyInjection;

use Sylius\Component\Resource\Factory\Factory;
use SymEdit\Bundle\CoreBundle\Controller\PageController;
use SymEdit\Bundle\CoreBundle\Form\Type\PageType;
use SymEdit\Bundle\CoreBundle\Model\Page;
use SymEdit\Bundle\CoreBundle\Model\PageInterface;
use SymEdit\Bundle\CoreBundle\Model\Role;
use SymEdit\Bundle\CoreBundle\Model\RoleInterface;
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
        $rootNode = $treeBuilder->root('symedit');

        $supportedDrivers = ['doctrine/orm', 'doctrine/mongodb'];

        $rootNode
            ->children()
                ->scalarNode('driver')
                    ->validate()
                        ->ifNotInArray($supportedDrivers)
                        ->thenInvalid('The driver %s is not supported. Choose one of '.json_encode($supportedDrivers))
                    ->end()
                    ->info('Database driver to use, one of: '.json_encode($supportedDrivers))
                    ->defaultValue('doctrine/orm')
                    ->cannotBeOverwritten()
                ->end()
                ->booleanNode('test')->end()
                ->arrayNode('email')
                    ->info('Default email address from which to send')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('sender')->defaultValue('email@example.com')->end()
                    ->end()
                ->end()
                ->arrayNode('template_locations')
                    ->prototype('scalar')->end()
                ->end()
                ->arrayNode('assets')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('javascripts')
                            ->prototype('scalar')->end()
                        ->end()
                        ->arrayNode('stylesheets')
                            ->prototype('scalar')->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

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

                        ->arrayNode('page')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->arrayNode('classes')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('model')->defaultValue(Page::class)->end()
                                        ->scalarNode('interface')->defaultValue(PageInterface::class)->end()
                                        ->scalarNode('controller')->defaultValue(PageController::class)->end()
                                        ->scalarNode('repository')->end()
                                        ->scalarNode('factory')->defaultValue(Factory::class)->end()
                                        ->scalarNode('form')->defaultValue(PageType::class)->cannotBeEmpty()->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()

                        ->arrayNode('role')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->arrayNode('classes')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('model')->defaultValue(Role::class)->end()
                                        ->scalarNode('interface')->defaultValue(RoleInterface::class)->end()
                                        ->scalarNode('factory')->defaultValue(Factory::class)->end()
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
