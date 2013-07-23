<?php

namespace Isometriks\Bundle\SymEditBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class TwigPathCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $bundles = array(
            'symedit' => 'IsometriksSymEditBundle',
            'host' => $container->getParameter('isometriks_symedit.host_bundle'),
        );

        $locations = array(
            'symedit' => null,
            'host' => null,
        );

        foreach ($container->getParameter('kernel.bundles') as $bundle => $class) {

            if(in_array($bundle, $bundles)) {
                $key = array_search($bundle, $bundles);
                $reflection = new \ReflectionClass($class);

                if (is_dir($dir = dirname($reflection->getFilename()).'/Resources/views')) {
                    $locations[$key] = $dir;
                }
            }
        }

        $loader = $container->getDefinition('twig.loader.filesystem');

        $this->addPath($loader, $locations['host']);
        $this->addPath($loader, $locations['symedit']);
    }

    private function addPath(Definition $loader, $path = null)
    {
        if($path === null) {
            return;
        }

        $loader->addMethodCall('addPath', array($path, 'SymEdit'));
    }
}