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

use SymEdit\Bundle\ResourceBundle\DependencyInjection\SymEditResourceExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;

class SymEditSettingsExtension extends SymEditResourceExtension implements PrependExtensionInterface
{
    protected $configFiles = array(
        'services.xml', 'loader.xml', 'twig.xml', 'shortcode.xml',
    );

    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $this->configure(
            $configs,
            new Configuration(),
            $container,
            self::CONFIGURE_LOADER | self::CONFIGURE_PARAMETERS
        );

        // Get settings files
        $bundles = $container->getParameter('kernel.bundles');
        $settingsFiles = $this->getSettingsFiles($bundles, array('yml', 'xml'));

        // Set settings files
        $settingsDefinition = $container->getDefinition('symedit_settings.factory');
        $settingsDefinition->replaceArgument(3, $settingsFiles);
    }

    private function getSettingsFiles($bundles, array $extensions = array())
    {
        $files = array();
        foreach ($bundles as $bundle) {
            $class = new \ReflectionClass($bundle);
            $dir = dirname($class->getFileName());

            foreach ($extensions as $extension) {
                $file = $dir.'/Resources/config/settings.'.$extension;
                if (file_exists($file)) {
                    $files[] = $file;
                }
            }
        }

        return $files;
    }

    public function prepend(ContainerBuilder $container)
    {
        $container->prependExtensionConfig('doctrine_cache', array(
            'providers' => array(
                'symedit_settings' => array(
                    'php_file' => array(
                        'extension' => 'php',
                        'directory' => '%kernel.cache_dir%/symedit_settings',
                    ),
                ),
            ),
        ));
    }

    public function getAlias()
    {
        return 'symedit_settings';
    }
}
