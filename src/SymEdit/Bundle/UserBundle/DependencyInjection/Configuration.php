<?php

namespace SymEdit\Bundle\UserBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('isometriks_user');

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
     * @param \Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition $node
     */
    private function addClassesSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('classes')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('user')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('model')->defaultValue('SymEdit\Bundle\CoreBundle\Model\User')->end()
                                ->scalarNode('controller')->defaultValue('SymEdit\Bundle\UserBundle\Controller\UserController')->end()
                                ->scalarNode('repository')->end()
                                ->scalarNode('form')->defaultValue('SymEdit\Bundle\UserBundle\Form\UserType')->end()
                            ->end()
                        ->end()
                        ->arrayNode('profile')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('model')->defaultValue('SymEdit\Bundle\UserBundle\Model\Profile')->end()
                                ->scalarNode('form')->defaultValue('SymEdit\Bundle\UserBundle\Form\ProfileType')->end()
                            ->end()
                        ->end()
                        ->arrayNode('admin_profile')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('model')->defaultValue('SymEdit\Bundle\UserBundle\Model\AdminProfile')->end()
                                ->scalarNode('form')->defaultValue('SymEdit\Bundle\UserBundle\Form\AdminProfileType')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}
