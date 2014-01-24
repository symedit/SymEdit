<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\SettingsBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class SymEditSettingsExtension extends Extension
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

        $container->setParameter('symedit_settings.loader.files.yaml', $yamlFiles);
        $container->setParameter('symedit_settings.loader.files.xml', $xmlFiles);

        $loader->load('services.xml');

        // Check for Twig global variable
        $twig = $config['twig'];

        $container->setParameter('symedit_settings.twig.extension.global', $twig['global']);

        if($twig['global']){
            $container->setParameter('symedit_settings.twig.extension.global_variable', $twig['global_variable']);
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

    public function getAlias()
    {
        return 'symedit_settings';
    }
}
