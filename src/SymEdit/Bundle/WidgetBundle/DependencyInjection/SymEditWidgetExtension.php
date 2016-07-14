<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\WidgetBundle\DependencyInjection;

use SymEdit\Bundle\ResourceBundle\DependencyInjection\SymEditResourceExtension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class SymEditWidgetExtension extends SymEditResourceExtension implements PrependExtensionInterface
{
    protected $configFiles = [
        'services.xml',
        'widget.xml',
        'form.xml',
    ];

    /**
     * {@inheritdoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $config = $this->processConfiguration($this->getConfiguration($config, $container), $config);
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        // Load Resources
        $this->registerResources('symedit', $config['driver'], $config['resources'], $container);

        // Load Config Files
        $configFiles = [
            'services.xml',
            'widget.xml',
            'form.xml',
        ];

        foreach ($configFiles as $configFile) {
            $loader->load($configFile);
        }

        // Map Fragment Parameters
        $this->remapParameters($container, 'fragment', $config['fragment']);

        // Set Renderers
        $this->setupRenderers($container, $config['renderer']);
    }

    protected function setupRenderers(ContainerBuilder $container, array $renderers)
    {
        foreach (['widget', 'area'] as $renderer) {
            $container->setAlias(sprintf('symedit_widget.renderer.%s.default', $renderer), $renderers[$renderer]);
        }
    }

    public function prepend(ContainerBuilder $container)
    {
        if (!$container->hasExtension('symedit')) {
            return;
        }

        $container->prependExtensionConfig('symedit', [
            'template_locations' => [
                '@SymEditWidgetBundle/Resources/views',
            ],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'symedit_widget';
    }
}
