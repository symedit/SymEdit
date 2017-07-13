<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\FormBuilderBundle\DependencyInjection;

use Sylius\Component\Resource\Factory\Factory;
use SymEdit\Bundle\FormBuilderBundle\Controller\FormBuilderController;
use SymEdit\Bundle\FormBuilderBundle\Controller\FormElementController;
use SymEdit\Bundle\FormBuilderBundle\Factory\FormElementFactory;
use SymEdit\Bundle\FormBuilderBundle\Form\Type\FormBuilderType;
use SymEdit\Bundle\FormBuilderBundle\Form\Type\FormElementType;
use SymEdit\Bundle\FormBuilderBundle\Model\Form;
use SymEdit\Bundle\FormBuilderBundle\Model\FormElement;
use SymEdit\Bundle\FormBuilderBundle\Model\FormElementInterface;
use SymEdit\Bundle\FormBuilderBundle\Model\FormInterface;
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
        $rootNode = $treeBuilder->root('symedit_form_builder');

        $rootNode
            ->children()
                ->scalarNode('driver')->cannotBeEmpty()->defaultValue('doctrine/orm')->end()
                ->scalarNode('action_route')->cannotBeEmpty()->defaultValue('symedit_form_builder_process')->end()
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
                ->arrayNode('resources')
                    ->addDefaultsIfNotSet()
                    ->children()

                        ->arrayNode('form_builder')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->arrayNode('classes')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('model')->defaultValue(Form::class)->end()
                                        ->scalarNode('interface')->defaultValue(FormInterface::class)->end()
                                        ->scalarNode('controller')->defaultValue(FormBuilderController::class)->end()
                                        ->scalarNode('repository')->end()
                                        ->scalarNode('factory')->defaultValue(Factory::class)->end()
                                        ->scalarNode('form')->defaultValue(FormBuilderType::class)->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()

                        ->arrayNode('form_element')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->arrayNode('classes')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('model')->defaultValue(FormElement::class)->end()
                                        ->scalarNode('interface')->defaultValue(FormElementInterface::class)->end()
                                        ->scalarNode('controller')->defaultValue(FormElementController::class)->end()
                                        ->scalarNode('repository')->end()
                                        ->scalarNode('factory')->defaultValue(FormElementFactory::class)->end()
                                        ->scalarNode('form')->defaultValue(FormElementType::class)->end()
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
