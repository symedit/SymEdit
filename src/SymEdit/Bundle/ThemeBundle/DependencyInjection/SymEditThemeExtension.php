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

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class SymEditThemeExtension extends Extension implements PrependExtensionInterface
{
    protected $configFiles = [
        'services',
        'theme',
        'template',
        'layout',
    ];

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        foreach ($this->configFiles as $file) {
            $loader->load($file.'.xml');
        }

        $container->setParameter('symedit_theme.debug', $config['debug']);
        $container->setParameter('symedit_theme.theme_directory', $config['theme_directory']);
        $container->setParameter('symedit_theme.public_directory', $config['public_directory']);
        $container->setParameter('symedit_theme.active_theme', $config['active_theme']);
        $container->setParameter('symedit_theme.namespace_overrides', $config['namespace_overrides']);
        $container->setParameter('symedit_theme.templates.bundles', $config['templates']['bundles']);
    }

    public function prepend(ContainerBuilder $container)
    {
        /*
         * Twig Extension
         */
        $container->prependExtensionConfig('twig', [
            'form_themes' => [
                'SymEditThemeBundle:Form:fields.html.twig',
            ],
        ]);

        /*
         * Doctrine Cache
         */
        $container->prependExtensionConfig('doctrine_cache', [
            'providers' => [
                'symedit_theme' => [
                    'file_system' => [
                        'directory' => '%kernel.cache_dir%/symedit_theme',
                    ],
                ],
            ],
        ]);

        /*
         * Stylizer Extension
         */
        if ($container->hasExtension('symedit_stylizer')) {
            $container->prependExtensionConfig('symedit_stylizer', [
                'storage' => 'symedit_theme.stylizer.storage.theme',
            ]);
        }
    }

    public function getAlias()
    {
        return 'symedit_theme';
    }
}
