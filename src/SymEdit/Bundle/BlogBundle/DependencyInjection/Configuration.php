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

use Sylius\Component\Resource\Factory\Factory;
use SymEdit\Bundle\BlogBundle\Controller\PostController;
use SymEdit\Bundle\BlogBundle\Form\Type\CategoryType;
use SymEdit\Bundle\BlogBundle\Form\Type\PostType;
use SymEdit\Bundle\BlogBundle\Model\Category;
use SymEdit\Bundle\BlogBundle\Model\CategoryInterface;
use SymEdit\Bundle\BlogBundle\Model\Post;
use SymEdit\Bundle\BlogBundle\Model\PostInterface;
use SymEdit\Bundle\ResourceBundle\Controller\ResourceController;
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
        $rootNode = $treeBuilder->root('symedit_blog');

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
                        ->arrayNode('post')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->arrayNode('classes')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('model')->defaultValue(Post::class)->end()
                                        ->scalarNode('interface')->defaultValue(PostInterface::class)->end()
                                        ->scalarNode('controller')->defaultValue(PostController::class)->end()
                                        ->scalarNode('respository')->end()
                                        ->scalarNode('factory')->defaultValue(Factory::class)->end()
                                        ->scalarNode('form')->defaultValue(PostType::class)->cannotBeEmpty()->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()

                        ->arrayNode('category')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->arrayNode('classes')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('model')->defaultValue(Category::class)->end()
                                        ->scalarNode('interface')->defaultValue(CategoryInterface::class)->end()
                                        ->scalarNode('controller')->defaultValue(ResourceController::class)->end()
                                        ->scalarNode('respository')->end()
                                        ->scalarNode('factory')->defaultValue(Factory::class)->end()
                                        ->scalarNode('form')->defaultValue(CategoryType::class)->cannotBeEmpty()->end()
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
