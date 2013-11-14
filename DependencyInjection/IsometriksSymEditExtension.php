<?php

namespace Isometriks\Bundle\SymEditBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Loader\FileLoader;

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
            'model', 'menu', 'seo',
        );

        foreach($configFiles as $file){
            $loader->load($file.'.xml');
        }

        /**
         * Load DB Driver
         */
        $this->loadDbDriver($container, $config, $loader);
        
        $this->remapParameters($container, 'email', $config['email']);
        $this->remapParameters($container, 'fragment', $config['fragment']);
        $this->remapParameters($container, 'profile', $config['profile']);
        
        $container->setParameter('isometriks_symedit.extensions.routes', $config['extensions']);
        $container->setParameter('isometriks_symedit.admin_dir', $config['admin_dir']);
    }
    
    private function loadDbDriver(ContainerBuilder $container, array $config, FileLoader $loader)
    {
        $driver = $config['db_driver'];
        $container->setParameter('isometriks_symedit.model_manager_name', $config['model_manager_name']);
        $container->setParameter(sprintf('%s.backend_type_%s', $this->getAlias(), $driver), true);
        
        $container->setParameter('isometriks_symedit.db_driver', $driver);
        $loader->load(sprintf('driver/%s.xml', $driver));        
    }

    private function remapParameters(ContainerBuilder $container, $path, array $config)
    {        
        $prefix = rtrim($this->getAlias().'.'.$path, '.');
        
        foreach ($config as $key => $value) {
            $container->setParameter(sprintf('%s.%s', $prefix, $key), $value);
        }
    }
    
    public function getAlias()
    {
        return 'isometriks_symedit';
    }
}
