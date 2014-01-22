<?php

namespace SymEdit\Bundle\MediaBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('symedit_media');

        $rootNode
            ->children()
                ->scalarNode('driver')->defaultValue('doctrine/orm')->end()
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
                        ->arrayNode('media')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('form')->defaultValue('SymEdit\Bundle\MediaBundle\Form\Type\MediaType')->end()
                            ->end()
                        ->end()
                        ->arrayNode('image')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('model')->defaultValue('SymEdit\Bundle\MediaBundle\Model\Image')->end()
                                ->scalarNode('controller')->defaultValue('SymEdit\Bundle\ResourceBundle\Controller\ResourceController')->end()
                                ->scalarNode('respository')->end()
                                ->scalarNode('form')->defaultValue('SymEdit\Bundle\MediaBundle\Form\Type\ImageType')->end()
                            ->end()
                        ->end()
                        ->arrayNode('file')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('model')->defaultValue('SymEdit\Bundle\MediaBundle\Model\File')->end()
                                ->scalarNode('controller')->defaultValue('SymEdit\Bundle\ResourceBundle\Controller\ResourceController')->end()
                                ->scalarNode('repository')->end()
                                ->scalarNode('form')->defaultValue('SymEdit\Bundle\MediaBundle\Form\Type\FileType')->end()
                            ->end()
                        ->end()
                        ->arrayNode('media_gallery')
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

