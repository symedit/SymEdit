<?php

namespace SymEdit\Bundle\SettingsBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use SymEdit\Bundle\SettingsBundle\DependencyInjection\Loader\YamlSettingLoader; 

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class IsometriksSettingsExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        
        $bundles = $container->getParameter('kernel.bundles'); 
        
        $yamlFiles = $this->getYamlSettingsFiles($bundles); 
        $xmlFiles = $this->getXmlSettingsFiles($bundles); 

        $container->setParameter('isometriks_settings.loader.files.yaml', $yamlFiles);
        $container->setParameter('isometriks_settings.loader.files.xml', $xmlFiles); 
        
        $loader->load('services.xml');  
        
        // Check for Twig global variable
        $twig = $config['twig']; 
        
        $container->setParameter('isometriks_settings.twig.extension.global', $twig['global']); 
        
        if($twig['global']){
            $container->setParameter('isometriks_settings.twig.extension.global_variable', $twig['global_variable']); 
            $loader->load('twig.xml'); 
        }
    }
    
    private function getYamlSettingsFiles($bundles)
    {
        $files = array(); 
        foreach($bundles as $bundle){
            $class = new \ReflectionClass($bundle); 
            $dir = dirname($class->getFileName()); 
            $file = $dir.'/Resources/config/settings.yml'; 
            if(file_exists($file)){
                $files[] = $file; 
            }
        }
        
        return $files; 
    }
    
    private function getXmlSettingsFiles($bundles)
    {
        $files = array(); 
        foreach($bundles as $bundle){
            $class = new \ReflectionClass($bundle); 
            $dir = dirname($class->getFileName()); 
            $file = $dir.'/Resources/config/settings.xml'; 
            if(file_exists($file)){
                $files[] = $file; 
            }
        }
        
        return $files; 
    }
}
