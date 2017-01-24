<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\EventsBundle\DependencyInjection;

use SymEdit\Bundle\ResourceBundle\DependencyInjection\SymEditResourceExtension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class SymEditEventsExtension extends SymEditResourceExtension implements PrependExtensionInterface
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
            'form.xml',
            'widget.xml',
        ];

        foreach ($configFiles as $configFile) {
            $loader->load($configFile);
        }
    }

    public function prepend(ContainerBuilder $container)
    {
        /*
         * SymEdit Config, add the views
         */
        if ($container->hasExtension('symedit')) {
            $container->prependExtensionConfig('symedit', [
                'template_locations' => [
                    '@SymEditEventsBundle/Resources/views',
                ],
                'assets' => [
                    'javascripts' => [
                        '@SymEditEventsBundle/Resources/js/bootstrap-datetimepicker.min.js',
                        '@SymEditEventsBundle/Resources/js/activate.js',
                    ],
                    'stylesheets' => [
                        '@SymEditEventsBundle/Resources/css/bootstrap-datetimepicker.min.css',
                    ],
                ],
            ]);
        }
    }

    public function getAlias()
    {
        return 'symedit_events';
    }
}
