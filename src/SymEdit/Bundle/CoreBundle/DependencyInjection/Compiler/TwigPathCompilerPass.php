<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;

class TwigPathCompilerPass implements CompilerPassInterface
{
    protected $kernel;
    protected $locations;

    public function __construct(Kernel $kernel)
    {
        $this->kernel = $kernel;
        $this->locations = [];
    }

    public function process(ContainerBuilder $container)
    {
        $rootDir = $container->getParameter('kernel.root_dir');

        /*
         * Add root_dir/Resources/SymEditBundle/views
         */
        $this->addLocation(sprintf('%s/Resources/SymEditBundle/views', $rootDir));

        /*
         * Add the override paths sent to symedit
         */
        array_map([$this, 'addLocation'], $container->getParameter('symedit.template_locations'));

        /*
         * Add the SymEdit Locations and all parents
         */
        array_map([$this, 'mapBundles'], $this->kernel->getBundle('SymEditBundle', false));

        /*
         * Add the paths to the Twig Loader Definition
         */
        $loader = $container->getDefinition('twig.loader.filesystem');

        foreach (array_reverse($this->getLocations()) as $location) {
            $loader->addMethodCall('prependPath', [$location, 'SymEdit']);
        }
    }

    protected function mapBundles($bundle)
    {
        $this->addLocation($bundle->getPath().'/Resources/views');
    }

    protected function addLocation($dir)
    {
        // Locate if needed
        if ($dir[0] === '@') {
            $dir = $this->kernel->locateResource($dir);
        }

        if (is_dir($dir)) {
            $this->locations[] = $dir;
        }
    }

    protected function getLocations()
    {
        return $this->locations;
    }
}
