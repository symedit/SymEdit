<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
                ->arrayNode('paths')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('image')->defaultValue('media/image')->end()
                        ->scalarNode('file')->defaultValue('media/file')->end()
                    ->end()
                ->end()
                ->scalarNode('namer')->defaultValue('symedit_media.namer.slug')->end()
            ->end();

        $this->addClassesSection($rootNode);

        return $treeBuilder;
    }

    /**
     * Add classes config to be processed by the Sylius Resource Bundle.
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
                                ->scalarNode('model')->defaultValue('SymEdit\Bundle\MediaBundle\Model\Media')->end()
                                ->scalarNode('form')->defaultValue('SymEdit\Bundle\MediaBundle\Form\Type\MediaType')->end()
                                ->scalarNode('repository')->end()
                            ->end()
                        ->end()
                        ->arrayNode('image')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('model')->defaultValue('SymEdit\Bundle\MediaBundle\Model\Image')->end()
                                ->scalarNode('controller')->defaultValue('SymEdit\Bundle\MediaBundle\Controller\ImageController')->end()
                                ->scalarNode('respository')->end()
                                ->scalarNode('form')->defaultValue('SymEdit\Bundle\MediaBundle\Form\Type\ImageType')->end()
                            ->end()
                        ->end()
                        ->arrayNode('file')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('model')->defaultValue('SymEdit\Bundle\MediaBundle\Model\File')->end()
                                ->scalarNode('controller')->defaultValue('SymEdit\Bundle\MediaBundle\Controller\FileController')->end()
                                ->scalarNode('repository')->end()
                                ->scalarNode('form')->defaultValue('SymEdit\Bundle\MediaBundle\Form\Type\FileType')->end()
                            ->end()
                        ->end()
                        ->arrayNode('image_gallery')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('model')->defaultValue('SymEdit\Bundle\MediaBundle\Model\ImageGallery')->end()
                                ->scalarNode('controller')->defaultValue('SymEdit\Bundle\ResourceBundle\Controller\ResourceController')->end()
                                ->scalarNode('repository')->end()
                                ->scalarNode('form')->defaultValue('SymEdit\Bundle\MediaBundle\Form\Type\ImageGalleryType')->end()
                            ->end()
                        ->end()
                        ->arrayNode('gallery_item')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('model')->defaultValue('SymEdit\Bundle\MediaBundle\Model\GalleryItem')->end()
                                ->scalarNode('controller')->defaultValue('SymEdit\Bundle\MediaBundle\Controller\GalleryItemController')->end()
                                ->scalarNode('repository')->end()
                                ->scalarNode('form')->defaultValue('SymEdit\Bundle\MediaBundle\Form\Type\GalleryItemType')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}
