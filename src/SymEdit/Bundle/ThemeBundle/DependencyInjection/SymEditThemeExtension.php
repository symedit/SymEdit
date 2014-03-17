<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\ThemeBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class SymEditThemeExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
        $loader->load('theme.xml');
        $loader->load('template.xml');

        $container->setParameter('symedit_theme.theme_directory', $config['theme_directory']);
        $container->setParameter('symedit_theme.public_directory', $config['public_directory']);
        $container->setParameter('symedit_theme.active_theme', $config['active_theme']);
        $container->setParameter('symedit_theme.namespace_overrides', $config['namespace_overrides']);
        $container->setParameter('symedit_theme.templates.bundles', $config['templates']['bundles']);
    }

    public function getAlias()
    {
        return 'symedit_theme';
    }
}
