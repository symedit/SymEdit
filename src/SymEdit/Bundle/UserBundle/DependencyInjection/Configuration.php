<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\UserBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('symedit_user');

        $rootNode
            ->children()
                ->scalarNode('driver')->cannotBeEmpty()->defaultValue('doctrine/orm')->end()
                ->arrayNode('notifications')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('registration')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->booleanNode('enabled')->defaultTrue()->end()
                                ->booleanNode('template')->defaultValue('@SymEdit/Email/registration.html.twig')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        $this->addClassesSection($rootNode);

        return $treeBuilder;
    }

    /**
     * Add classes config to be processed by the Sylius Resource Bundle.
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
                                ->scalarNode('model')->defaultValue('SymEdit\Bundle\UserBundle\Model\User')->end()
                                ->scalarNode('controller')->defaultValue('SymEdit\Bundle\UserBundle\Controller\UserController')->end()
                                ->scalarNode('repository')->end()
                                ->arrayNode('form')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('default')->defaultValue('SymEdit\Bundle\UserBundle\Form\Type\UserType')->end()
                                        ->scalarNode('choose')->defaultValue('SymEdit\Bundle\UserBundle\Form\Type\UserChooseType')->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('profile')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('model')->defaultValue('SymEdit\Bundle\UserBundle\Model\Profile')->end()
                                ->scalarNode('form')->defaultValue('SymEdit\Bundle\UserBundle\Form\Type\UserProfileType')->end()
                            ->end()
                        ->end()
                        ->arrayNode('admin_profile')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('model')->defaultValue('SymEdit\Bundle\UserBundle\Model\AdminProfile')->end()
                                ->scalarNode('controller')->defaultValue('SymEdit\Bundle\ResourceBundle\Controller\ResourceController')->end()
                                ->scalarNode('form')->defaultValue('SymEdit\Bundle\UserBundle\Form\Type\AdminProfileType')->end()
                            ->end()
                        ->end()
                        ->arrayNode('registration')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('form')->defaultValue('SymEdit\Bundle\UserBundle\Form\Type\RegistrationFormType')->end()
                            ->end()
                    ->end()
                ->end()
            ->end();
    }
}
