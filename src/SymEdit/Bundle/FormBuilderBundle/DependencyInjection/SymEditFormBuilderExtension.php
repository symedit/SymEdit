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

use SymEdit\Bundle\ResourceBundle\DependencyInjection\SymEditResourceExtension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class SymEditFormBuilderExtension extends SymEditResourceExtension implements PrependExtensionInterface
{
    protected $configFiles = [
        'services.xml',
        'fields.xml',
        'widget.xml',
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
            'fields.xml',
            'widget.xml',
        ];

        foreach ($configFiles as $configFile) {
            $loader->load($configFile);
        }

        $container->setParameter('symedit_form_builder.action_route', $config['action_route']);
    }

    public function prepend(ContainerBuilder $container)
    {
        if (!$container->hasExtension('symedit')) {
            return;
        }

        $container->prependExtensionConfig('symedit', [
            'template_locations' => [
                '@SymEditFormBuilderBundle/Resources/views',
            ],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'symedit_form_builder';
    }
}
