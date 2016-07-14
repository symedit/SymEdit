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

use SymEdit\Bundle\ResourceBundle\DependencyInjection\SymEditResourceExtension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class SymEditUserExtension extends SymEditResourceExtension implements PrependExtensionInterface
{
    protected $configFiles = [
        'services.xml',
        'form.xml',
        'notifications.xml',
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
            'form.xml',
            'notifications.xml',
        ];

        foreach ($configFiles as $configFile) {
            $loader->load($configFile);
        }

        foreach ($config['notifications'] as $type => $notification) {
            if (!$notification['enabled']) {
                $container->removeDefinition('symedit_user.notification.'.$type);
            } else {
                $this->remapParameters($container, 'notifications.'.$type, $notification);
            }
        }

        // Set Registration Form Class
        $container->setParameter('symedit.form.type.registration.class', $config['registration']['class']);
    }

    public function prepend(ContainerBuilder $container)
    {
        $container->prependExtensionConfig('fos_user', [
            'user_class' => '%symedit.model.user.class%',
            'service' => [
                'user_manager' => 'symedit_user.user_manager',
            ],
            'registration' => [
                'form' => [
                    'type' => 'symedit_user_registration',
                ],
            ],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'symedit_user';
    }
}
