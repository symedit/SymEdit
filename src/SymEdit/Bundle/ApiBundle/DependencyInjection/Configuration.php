<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\ApiBundle\DependencyInjection;

use SymEdit\Bundle\ApiBundle\Model\AccessToken;
use SymEdit\Bundle\ApiBundle\Model\AccessTokenInterface;
use SymEdit\Bundle\ApiBundle\Model\AuthCode;
use SymEdit\Bundle\ApiBundle\Model\AuthCodeInterface;
use SymEdit\Bundle\ApiBundle\Model\Client;
use SymEdit\Bundle\ApiBundle\Model\ClientInterface;
use SymEdit\Bundle\ApiBundle\Model\RefreshToken;
use SymEdit\Bundle\ApiBundle\Model\RefreshTokenInterface;
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
        $rootNode = $treeBuilder->root('symedit_api');

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

                        ->arrayNode('client')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->arrayNode('classes')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('model')->defaultValue(Client::class)->end()
                                        ->scalarNode('interface')->defaultValue(ClientInterface::class)->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()

                        ->arrayNode('access_token')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->arrayNode('classes')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('model')->defaultValue(AccessToken::class)->end()
                                        ->scalarNode('interface')->defaultValue(AccessTokenInterface::class)->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()

                        ->arrayNode('refresh_token')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->arrayNode('classes')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('model')->defaultValue(RefreshToken::class)->end()
                                        ->scalarNode('interface')->defaultValue(RefreshTokenInterface::class)->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()

                        ->arrayNode('auth_code')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->arrayNode('classes')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('model')->defaultValue(AuthCode::class)->end()
                                        ->scalarNode('interface')->defaultValue(AuthCodeInterface::class)->end()
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
