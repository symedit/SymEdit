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

use SymEdit\Bundle\ResourceBundle\DependencyInjection\SymEditResourceExtension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class SymEditApiExtension extends SymEditResourceExtension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $config = $this->processConfiguration($this->getConfiguration($config, $container), $config);
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        // Load Resources
        $this->registerResources('symedit', $config['driver'], $config['resources'], $container);
    }

    public function getAlias()
    {
        return 'symedit_api';
    }

    public function prepend(ContainerBuilder $container)
    {
        if (!$container->hasExtension('fos_oauth_server')) {
            throw new ServiceNotFoundException('fos_oauth_server required to use API Bundle');
        }

        $container->prependExtensionConfig('fos_oauth_server', [
            'db_driver' => 'orm',
            'client_class' => '%symedit.model.client.class%',
            'access_token_class' => '%symedit.model.access_token.class%',
            'refresh_token_class' => '%symedit.model.refresh_token.class%',
            'auth_code_class' => '%symedit.model.auth_code.class%',
            'service' => [
                'user_provider' => 'fos_user.user_provider.username',
            ],
        ]);
    }
}
