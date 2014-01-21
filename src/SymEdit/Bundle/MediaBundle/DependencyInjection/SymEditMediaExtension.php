<?php

namespace SymEdit\Bundle\MediaBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class SymEditMediaExtension extends Extension
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

        $driver = $config['db_driver'];
        $loader->load(sprintf('driver/%s.xml', $driver));

        $container->setParameter('symedit_media.model_manager_name', $config['model_manager_name']);
        $container->setParameter(sprintf('%s.backend_type_%s', $this->getAlias(), $driver), true);

        /**
         * Set directories
         */
        $container->setParameter('symedit_media.web_root', rtrim($config['web_root'], '/'));
        $container->setParameter('symedit_media.upload_dir', ltrim($config['upload_dir'], '/'));
    }

    public function getAlias()
    {
        return 'symedit_media';
    }
}
