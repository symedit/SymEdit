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
        
        foreach(array('services', 'widget', 'routing', 'form', 'event', 'twig', 'util', 'profiler') as $file){
            $loader->load($file.'.xml'); 
        }        
        
        /**
         * Add Classes to Compile
         */
        $this->addClassesToCompile(array(
            // services.xml
            'Isometriks\\Bundle\\SymEditBundle\\Finder\\ResourceFinder', 
            'Isometriks\\Bundle\\SymEditBundle\\Templating\\TemplateGuesser', 
            
            // event.xml
            'Isometriks\\Bundle\\SymEditBundle\\EventListener\\ControllerListener', 
            
            // twig.xml
            'Isometriks\\Bundle\\SymEditBundle\\Twig\\Extension\\SymEditExtension',
        )); 
           
        /**
         * Setup the Host Bundle and make sure it exists
         */
        if(!isset($config['host_bundle'])){
            throw new \Exception('host_bundle not defined'); 
        } else {
            $bundles = $container->getParameter('kernel.bundles'); 
            $bundle  = $config['host_bundle']; 
            
            if(!array_key_exists($bundle, $bundles)){
                throw new \Exception(sprintf('Host Bundle "%s" does not exist.', $bundle)); 
            }
            
            /**
             * Bundle namespace
             */
            $bundleInstance = new \ReflectionClass($bundles[$bundle]); 
            $namespace = $bundleInstance->getNamespaceName(); 
            
            /**
             * Bundle directory
             */
            $directory = dirname($bundleInstance->getFileName()); 
            
            $container->setParameter('isometriks_sym_edit.host_namespace', $namespace);  
            $container->setParameter('isometriks_sym_edit.host_bundle', $bundle); 
            $container->setParameter('isometriks_sym_edit.host_dir', $directory); 
        }
        
        $container->setParameter('isometriks_sym_edit.extensions.routes', $config['extensions']); 
        
        /**
         * Set the Admin Directory
         */
        $container->setParameter('isometriks_sym_edit.admin_dir', $config['admin_dir']); 
    }
}
