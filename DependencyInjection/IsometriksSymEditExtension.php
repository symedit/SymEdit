<?php

namespace Isometriks\Bundle\SymEditBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class IsometriksSymEditExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $configFiles = array(
            'services', 'user', 'widget', 'routing',
            'form', 'event', 'twig', 'util', 'profiler',
            'model', 'menu',
        );

        foreach($configFiles as $file){
            $loader->load($file.'.xml');
        }

        /**
         * Load DB Driver
         */
        $driver = $config['db_driver'];
        $container->setParameter('isometriks_symedit.model_manager_name', $config['model_manager_name']);
        $container->setParameter(sprintf('%s.backend_type_%s', $this->getAlias(), $driver), true);
        
        $container->setParameter('isometriks_symedit.db_driver', $driver);
        $loader->load(sprintf('driver/%s.xml', $driver));
        
        $this->loadEmail($config['email'], $container);
        $this->loadFragment($config['fragment'], $container);

        $container->setParameter('isometriks_symedit.extensions.routes', $config['extensions']);
        $container->setParameter('isometriks_symedit.admin_dir', $config['admin_dir']);
    }

    /**
     * Load Email Settings
     */
    private function loadEmail($config, ContainerBuilder $container)
    {
        $container->setParameter('isometriks_symedit.email.sender', $config['sender']);
    }
    
    /**
     * Load Fragment Settings
     */
    private function loadFragment($config, ContainerBuilder $container)
    {
        $container->setParameter('isometriks_symedit.fragment.strategy', $config['strategy']);
    }

    public function getAlias()
    {
        return 'isometriks_symedit';
    }
}
