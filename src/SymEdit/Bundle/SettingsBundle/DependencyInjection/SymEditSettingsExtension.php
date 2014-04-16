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
        $settingsFiles = $this->getSettingsFiles($bundles, array('yml', 'xml'));

        // Load Services
        $loader->load('services.xml');

        // Set settings files
        $settingsDefinition = $container->getDefinition('symedit_settings.settings');
        $settingsDefinition->replaceArgument(1, $settingsFiles);

        // Load Loaders
        $loader->load('loader.xml');

        // Load Twig Extension
        $loader->load('twig.xml');
    }

    private function getSettingsFiles($bundles, array $extensions = array())
    {
        $files = array();
        foreach($bundles as $bundle){
            $class = new \ReflectionClass($bundle);
            $dir = dirname($class->getFileName());

            foreach ($extensions as $extension) {
                $file = $dir.'/Resources/config/settings.' . $extension;
                if(file_exists($file)){
                    $files[] = $file;
                }
            }
        }

        return $files;
    }

    public function getAlias()
    {
        return 'symedit_settings';
    }
}
