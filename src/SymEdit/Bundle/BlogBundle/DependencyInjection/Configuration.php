<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\BlogBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
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
        $rootNode = $treeBuilder->root('symedit_blog');

        $rootNode
            ->children()
                ->scalarNode('driver')->cannotBeEmpty()->defaultValue('doctrine/orm')->end()
                ->scalarNode('model_manager_name')->defaultNull()->end()
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
                        ->arrayNode('post')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('model')->defaultValue('SymEdit\Bundle\BlogBundle\Model\Post')->end()
                                ->scalarNode('controller')->defaultValue('SymEdit\Bundle\BlogBundle\Controller\PostController')->end()
                                ->scalarNode('respository')->end()
                                ->scalarNode('form')->defaultValue('SymEdit\Bundle\BlogBundle\Form\Type\PostType')->end()
                            ->end()
                        ->end()
                        ->arrayNode('category')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('model')->defaultValue('SymEdit\Bundle\BlogBundle\Model\Category')->end()
                                ->scalarNode('controller')->defaultValue('SymEdit\Bundle\BlogBundle\Controller\CategoryController')->end()
                                ->scalarNode('respository')->end()
                                ->scalarNode('form')->defaultValue('SymEdit\Bundle\BlogBundle\Form\Type\CategoryType')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}
