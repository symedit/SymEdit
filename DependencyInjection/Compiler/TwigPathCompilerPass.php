<?php

namespace Isometriks\Bundle\SymEditBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class TwigPathCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $hostBundle = $container->getParameter('isometriks_symedit.host_bundle');

        $bundles = array(
            'host' => $hostBundle,
            'symedit' => 'IsometriksSymEditBundle',
        );

        $locations = array(
            'app' => null,
            'host' => null,
            'symedit' => null,
        );

        /**
         * Check the app directory
         */
        $rootDir = $container->getParameter('kernel.root_dir');

        if(is_dir($dir = $rootDir.'/Resources/'.$hostBundle.'/views')) {
            $locations['app'] = $dir;
        }

        foreach ($container->getParameter('kernel.bundles') as $bundle => $class) {

            if(in_array($bundle, $bundles)) {
                $key = array_search($bundle, $bundles);
                $reflection = new \ReflectionClass($class);

                if (is_dir($dir = dirname($reflection->getFilename()).'/Resources/views')) {
                    $locations[$key] = $dir;
                }
            }
        }

        /**
         * Add the paths to the Twig Loader Definition
         */
        $loader = $container->getDefinition('twig.loader.filesystem');

        foreach($locations as $location){

            if($location === null) {
                continue;
            }

            $loader->addMethodCall('addPath', array($location, 'SymEdit'));
        }
    }
}