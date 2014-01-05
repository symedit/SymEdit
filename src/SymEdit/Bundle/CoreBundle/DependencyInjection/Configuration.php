<?php

namespace SymEdit\Bundle\CoreBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('isometriks_symedit');

        $supportedDrivers = array('doctrine/orm', 'doctrine/mongodb');

        $rootNode
            ->children()
                ->scalarNode('driver')
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

        $this->addClassesSection($rootNode);

        return $treeBuilder;
    }

    /**
     * Add classes config to be processed by the Sylius Resource Bundle
     *
     * @param \Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition $node
     */
    private function addClassesSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('classes')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('page')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('model')->defaultValue('SymEdit\Bundle\CoreBundle\Model\Page')->end()
                                ->scalarNode('controller')->defaultValue('SymEdit\Bundle\CoreBundle\Controller\Admin\PageController')->end()
                                ->scalarNode('repository')->end()
                                ->scalarNode('form')->defaultValue('SymEdit\Bundle\CoreBundle\Form\PageType')->end()
                            ->end()
                        ->end()
                        ->arrayNode('post')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('model')->defaultValue('SymEdit\Bundle\CoreBundle\Model\Post')->end()
                                ->scalarNode('controller')->defaultValue('SymEdit\Bundle\CoreBundle\Controller\PostController')->end()
                                ->scalarNode('respository')->end()
                                ->scalarNode('form')->defaultValue('SymEdit\Bundle\CoreBundle\Form\PostType')->end()
                            ->end()
                        ->end()
                        ->arrayNode('category')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('model')->defaultValue('SymEdit\Bundle\CoreBundle\Model\Category')->end()
                                ->scalarNode('controller')->defaultValue('SymEdit\Bundle\CoreBundle\Controller\Admin\CategoryController')->end()
                                ->scalarNode('respository')->end()
                                ->scalarNode('form')->defaultValue('SymEdit\Bundle\CoreBundle\Form\CategoryType')->end()
                            ->end()
                        ->end()
                        ->arrayNode('image')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('model')->defaultValue('Isometriks\Bundle\MediaBundle\Model\Media')->end()
                                ->scalarNode('controller')->defaultValue('SymEdit\Bundle\CoreBundle\Controller\ResourceController')->end()
                                ->scalarNode('repository')->end()
                                ->scalarNode('form')->defaultValue('SymEdit\Bundle\CoreBundle\Form\ImageType')->end()
                            ->end()
                        ->end()
                        ->arrayNode('widget')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('model')->defaultValue('SymEdit\Bundle\CoreBundle\Model\Widget')->end()
                                ->scalarNode('controller')->defaultValue('SymEdit\Bundle\CoreBundle\Controller\Admin\WidgetController')->end()
                                ->scalarNode('respository')->end()
                                ->scalarNode('form')->defaultValue('SymEdit\Bundle\CoreBundle\Form\WidgetType')->end()
                            ->end()
                        ->end()
                        ->arrayNode('widget_area')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('model')->defaultValue('SymEdit\Bundle\CoreBundle\Model\WidgetArea')->end()
                                ->scalarNode('repository')->end()
                                ->scalarNode('form')->defaultValue('SymEdit\Bundle\CoreBundle\Form\WidgetAreaType')->end()
                            ->end()
                        ->end()
                        ->arrayNode('slider')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('model')->defaultValue('SymEdit\Bundle\CoreBundle\Model\Slider')->end()
                                ->scalarNode('controller')->defaultValue('SymEdit\Bundle\CoreBundle\Controller\ResourceController')->end()
                                ->scalarNode('repository')->end()
                                ->scalarNode('form')->defaultValue('SymEdit\Bundle\CoreBundle\Form\SliderType')->end()
                            ->end()
                        ->end()
                        ->arrayNode('slide')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('model')->defaultValue('SymEdit\Bundle\CoreBundle\Model\Slide')->end()
                                ->scalarNode('controller')->defaultValue('SymEdit\Bundle\CoreBundle\Controller\ResourceController')->end()
                                ->scalarNode('repository')->end()
                                ->scalarNode('form')->defaultValue('SymEdit\Bundle\CoreBundle\Form\SlideType')->end()
                            ->end()
                        ->end()
                        ->arrayNode('settings')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('controller')->defaultValue('SymEdit\Bundle\CoreBundle\Controller\Admin\SettingsController')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}
