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

use Sylius\Component\Resource\Factory\Factory;
use SymEdit\Bundle\MediaBundle\Controller\FileController;
use SymEdit\Bundle\MediaBundle\Controller\ImageController;
use SymEdit\Bundle\MediaBundle\Factory\GalleryItemFactory;
use SymEdit\Bundle\MediaBundle\Form\Type\FileType;
use SymEdit\Bundle\MediaBundle\Form\Type\GalleryItemType;
use SymEdit\Bundle\MediaBundle\Form\Type\ImageGalleryType;
use SymEdit\Bundle\MediaBundle\Form\Type\ImageType;
use SymEdit\Bundle\MediaBundle\Form\Type\MediaType;
use SymEdit\Bundle\MediaBundle\Model\File;
use SymEdit\Bundle\MediaBundle\Model\FileInterface;
use SymEdit\Bundle\MediaBundle\Model\GalleryItem;
use SymEdit\Bundle\MediaBundle\Model\GalleryItemInterface;
use SymEdit\Bundle\MediaBundle\Model\Image;
use SymEdit\Bundle\MediaBundle\Model\ImageGallery;
use SymEdit\Bundle\MediaBundle\Model\ImageGalleryInterface;
use SymEdit\Bundle\MediaBundle\Model\ImageInterface;
use SymEdit\Bundle\MediaBundle\Model\Media;
use SymEdit\Bundle\MediaBundle\Model\MediaInterface;
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

                        ->arrayNode('media')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->arrayNode('classes')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('model')->defaultValue(Media::class)->end()
                                        ->scalarNode('interface')->defaultValue(MediaInterface::class)->end()
                                        ->scalarNode('repository')->end()
                                        ->scalarNode('form')->defaultValue(MediaType::class)->cannotBeEmpty()->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()

                        ->arrayNode('image')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->arrayNode('classes')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('model')->defaultValue(Image::class)->end()
                                        ->scalarNode('interface')->defaultValue(ImageInterface::class)->end()
                                        ->scalarNode('controller')->defaultValue(ImageController::class)->end()
                                        ->scalarNode('respository')->end()
                                        ->scalarNode('factory')->defaultValue(Factory::class)->end()
                                        ->scalarNode('form')->defaultValue(ImageType::class)->cannotBeEmpty()->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()

                        ->arrayNode('file')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->arrayNode('classes')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('model')->defaultValue(File::class)->end()
                                        ->scalarNode('interface')->defaultValue(FileInterface::class)->end()
                                        ->scalarNode('controller')->defaultValue(FileController::class)->end()
                                        ->scalarNode('repository')->end()
                                        ->scalarNode('factory')->defaultValue(Factory::class)->end()
                                        ->scalarNode('form')->defaultValue(FileType::class)->cannotBeEmpty()->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()

                        ->arrayNode('image_gallery')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->arrayNode('classes')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('model')->defaultValue(ImageGallery::class)->end()
                                        ->scalarNode('interface')->defaultValue(ImageGalleryInterface::class)->end()
                                        ->scalarNode('controller')->defaultValue(ResourceController::class)->end()
                                        ->scalarNode('repository')->end()
                                        ->scalarNode('factory')->defaultValue(Factory::class)->end()
                                        ->scalarNode('form')->defaultValue(ImageGalleryType::class)->cannotBeEmpty()->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()

                        ->arrayNode('gallery_item')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->arrayNode('classes')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('model')->defaultValue(GalleryItem::class)->end()
                                        ->scalarNode('interface')->defaultValue(GalleryItemInterface::class)->end()
                                        ->scalarNode('controller')->defaultValue(ResourceController::class)->end()
                                        ->scalarNode('repository')->end()
                                        ->scalarNode('factory')->defaultValue(GalleryItemFactory::class)->end()
                                        ->scalarNode('form')->defaultValue(GalleryItemType::class)->cannotBeEmpty()->end()
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
