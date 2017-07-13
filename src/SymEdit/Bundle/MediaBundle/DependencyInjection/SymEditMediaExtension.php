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

use SymEdit\Bundle\ResourceBundle\DependencyInjection\SymEditResourceExtension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class SymEditMediaExtension extends SymEditResourceExtension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $config = $this->processConfiguration($this->getConfiguration($config, $container), $config);
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        // Load Driver
        $loader->load(sprintf('driver/%s.xml', $config['driver']));

        // Load Resources
        $this->registerResources('symedit', $config['driver'], $config['resources'], $container);

        // Load Config Files
        $configFiles = [
            'services.xml',
            'form.xml',
            'widget.xml',
        ];

        foreach ($configFiles as $configFile) {
            $loader->load($configFile);
        }

        $this->remapParameters($container, 'paths', $config['paths']);
        $container->setParameter('symedit_media.paths', $config['paths']);
        $container->setParameter('symedit_media.namer', $config['namer']);

        $container->setAlias('symedit_media.namer', $config['namer']);
    }

    public function prepend(ContainerBuilder $container)
    {
        /*
         * Twig Extension
         */
        $container->prependExtensionConfig('twig', [
            'form_themes' => [
                'SymEditMediaBundle:Form:fields.html.twig',
            ],
        ]);

        if ($container->hasExtension('symedit')) {
            $container->prependExtensionConfig('symedit', [
                'template_locations' => [
                    '@SymEditMediaBundle/Resources/views',
                ],
                'assets' => [
                    'stylesheets' => [
                        '@SymEditMediaBundle/Resources/less/media.less',
                        '@SymEditMediaBundle/Resources/css/dropzone.css',
                    ],
                    'javascripts' => [
                        '@SymEditMediaBundle/Resources/js/media.js',
                        '@SymEditMediaBundle/Resources/js/dropzone.js',
                    ],
                ],
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'symedit_media';
    }
}
