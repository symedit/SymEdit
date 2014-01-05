<?php

namespace SymEdit\Bundle\CoreBundle\DependencyInjection\Compiler;

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class TwigPathCompilerPass implements CompilerPassInterface
{
    protected $kernel;
    protected $locations;

    public function __construct(Kernel $kernel)
    {
        $this->kernel = $kernel;
        $this->locations = array();
    }

    public function process(ContainerBuilder $container)
    {
        $rootDir = $container->getParameter('kernel.root_dir');

        /*
         * Add root_dir/Resources/IsometriksSymEditBundle/views
         */
        $this->addLocation(sprintf('%s/Resources/IsometriksSymEditBundle/views', $rootDir));

        /**
         * Add the SymEdit Locations and all parents
         */
        array_map(array($this, 'mapBundles'), $this->kernel->getBundle('IsometriksSymEditBundle',false));

        /**
         * Add the paths to the Twig Loader Definition
         */
        $loader = $container->getDefinition('twig.loader.filesystem');

        foreach($this->getLocations() as $location){
            $loader->addMethodCall('addPath', array($location, 'SymEdit'));
        }
    }

    protected function mapBundles($bundle)
    {
        $this->addLocation($bundle->getPath().'/Resources/views');
    }

    protected function addLocation($dir)
    {
        if(is_dir($dir)) {
            $this->locations[] = $dir;
        }
    }

    protected function getLocations()
    {
        return $this->locations;
    }
}